<?php 
	//En tête
    session_start();

    $db_handle = mysqli_connect('localhost', 'root', ''); 
    $db_found = mysqli_select_db($db_handle, "ebay_ece");

    $typeConnected=(isset($_SESSION['typeConnected']))?(int) $_SESSION['typeConnected']:1;
    //visiteur : 1
    //client : 2
    //vendeur : 3
    $idConnected=(isset($_SESSION['idConnected']))?(int) $_SESSION['idConnected']:0;
    //id si client connecté
    $pseudoConnected=(isset($_SESSION['pseudoConnected']))?$_SESSION['pseudoConnected']:'';
    //pseudo si vendeur connecté
    
	if(isset($_POST["toggleConnexion"])){
    	if($_POST["toggleConnexion"]){
    		if($typeConnected == 1){
    			header('Location: page_de_connexion.php');
    		}
    		if($typeConnected ==2 || $typeConnected == 3){
    			$_SESSION['typeConnected'] = 1;
    			$_SESSION['idConnected'] = 0;
    			$_SESSION['pseudoConnected'] = '';
    			$_SESSION['boolAdmin'] = 0;
    			header('Location: accueil_client.php');
    		}
    	}
    }

	if(isset($_POST["boutonCompte"])){
    	if($_POST["boutonCompte"]){
    		if($typeConnected == 2){	//client connecté
    			header('Location: profil_client.php');
    			exit();
    		}elseif ($typeConnected == 3){	//vendeur connecté
    			header('Location: profil_vendeur_prive.php');
    			exit();
    		}
    		else{
    			echo "Erreur : type de connexion : $typeConnected";
    		}
    	}
    }


	//Page
    $typePaiement = isset($_GET["typePaiement"])?$_GET["typePaiement"]:0;
    //0 - erreur
    //1 - panier
    //2 - enchère => autre attribut pour idEnchère
    //3 - négoce => autre attribut pour numero produit (ajouter un champ à negoce pour dire si la négoce est conclue)

    $produitPaye = isset($_GET["produitPaye"])?$_GET["produitPaye"]:"";
    //id du produit, si originaire d'enchères ou négoce

    $prixTotalPanier = 0;   // prix des produits pour lesquels on va payer. Désigne aussi bien le panier que le produit gagné aux enchère, selon le cas.
    $prixLivraison = 45.50; //arbitraire, car pas d'étude de lieu de livraison
    if ($db_found) {
        if($typePaiement < 1 || $typePaiement > 3){
            echo "Erreur : le type de paiement n'existe pas (type = $typePaiement)";
        }elseif ($typePaiement == 1) {  //paiement depuis panier

            //Requête pour retrouver la somme des prix des objets contenus dans le panier
            $sqlTotalPanier = "SELECT SUM(Pr.PrixDirect) as prixTotal from panier Pa join produit Pr on Pa.NumeroProduit = Pr.Numero where IDClient = $idConnected";
            $resultatTotal = mysqli_query($db_handle,$sqlTotalPanier) or die (mysqli_error($db_handle));
            if(mysqli_num_rows($resultatTotal) == 0){
                echo "Erreur : le panier est vide";
            }else{
                $dataTotalPanier = mysqli_fetch_assoc($resultatTotal);
                $prixTotalPanier = $dataTotalPanier["prixTotal"];
            }
        }elseif($typePaiement == 2){    //paiement depuis enchère.

            //Requête pour vérifier que le produit existe toujours
            $sqlObjectExist = "SELECT * from produit where Numero = $produitPaye";
            $resultatObjetExist = mysqli_query($db_handle,$sqlObjectExist) or die (mysqli_error($db_handle));
            if(mysqli_num_rows($resultatObjetExist) == 0){
               //L'objet n'existe pas 
                header('Location: accueil_client.php');
            }else{

                //Requête pour trouver le participant ayant fait la meilleure offre
                $sqlGagnantEnchere = "SELECT A.IDAcheteur as idGagnant,A.Valeur as montantGagnant,B.DateFin as dateFinEnchere from offre A join enchere B on A.IDEnchere = B.IDEnchere where B.IDEnchere = $produitPaye ORDER by A.Valeur desc,A.DateOffre asc limit 1;";
                $resultatGagnantEnchere = mysqli_query($db_handle,$sqlGagnantEnchere) or die (mysqli_error($db_handle));

                if(mysqli_num_rows($resultatGagnantEnchere) == 0){
                    echo "Erreur : pas de vainqueur trouvé pour l'enchère de ce produit";
                }else{
                    $dataGagnantEnchere = mysqli_fetch_assoc($resultatGagnantEnchere);

                    date_default_timezone_set('Europe/Paris');  //On va tester si l'enchère est bien terminée
                    $date = date('m/d/Y h:i:s a', time());  

                    if($dataGagnantEnchere["idGagnant"] == $idConnected && strtotime($date) > strtotime($dataGagnantEnchere["dateFinEnchere"])) { //Si c'est bien le client gagnant de l'enchère qui est connecté et si l'enchère est bien finie
                        
                        //Requête pour trouver le participant qui a fait la seconde meilleure offre
                        $sqlSecond = "SELECT A.Valeur as montantSecond from offre A join enchere B on A.IDEnchere = B.IDEnchere where B.IDEnchere = $produitPaye ORDER by A.Valeur desc,A.DateOffre asc limit 1 offset 1";
                        $resultatSecond = mysqli_query($db_handle,$sqlSecond) or die (mysqli_error($db_handle));
                        $dataSecond = mysqli_fetch_assoc($resultatSecond);

                        //Determination des prix
                        if($dataSecond["montantSecond"] == 0){  //1 seul participant à l'enchère
                            $prixTotalPanier = $dataGagnantEnchere["montantGagnant"];
                        }elseif($dataGagnantEnchere["montantGagnant"]-$dataSecond["montantSecond"] < 1){    //si les valeurs des 2 montants ne sont espacées que de 1€
                            $prixTotalPanier = $dataGagnantEnchere["montantGagnant"];
                        }elseif ($dataSecond["montantSecond"] < $dataGagnantEnchere["montantGagnant"]) {    // On prend un prix 1 € supérieur à la 2e meilleure offre
                            $prixTotalPanier = $dataSecond["montantSecond"] + 1;
                        }else{
                            echo "Erreur : le montant de l'enchère a mal été récupéré";
                        }
                    }elseif (strtotime($date) < strtotime($dataGagnantEnchere["dateFinEnchere"])) { //L'enchère n'est pas terminée
                        echo "<script>alert(\"Vous n'avez pas le droit d'acheter ce produit aux enchères : l'enchère n'est pas terminée.\")</script>";
                    }else{   //le client essaie de payer alors qu'il n'a pas gagné l'enchère
                        echo "<script>alert(\"Vous n'avez pas le droit d'acheter ce produit aux enchères : un autre client a déjà gagné.\")</script>";
                    }
                }
            }
        }elseif($typePaiement == 3){    //paiement depuis négociation

            //Requête pour trouver le tuple d'une négociation conclue, pour le bon produit et avec le bon acheteur
            $sqlNegociation = "SELECT * from negociation where IDAcheteur = $idConnected and NumeroProduit = $produitPaye and Accepted != 0";
            $resultatNegociation = mysqli_query($db_handle,$sqlNegociation) or die (mysqli_error($db_handle));
            if(mysqli_num_rows($resultatNegociation) == 0){
                echo "Erreur : Pas de négociation conclue trouvée pour ce produit";
            }else{
                $dataNegociation = mysqli_fetch_assoc($resultatNegociation);
                //On veut trouver la dernière offre faite
                $i=0;
                do{
                    $i++;
                }while ($i < 9 && isset($dataNegociation["Prop".($i+1)]));
                if($i == 9 && isset($dataNegociation["Prop".($i+1)])){  //on fait comme cela pour éviter de tester Prop11, qui n'est pas un champ
                    $i=10;
                }
                $prixTotalPanier = $dataNegociation["Prop".$i];
            }
        }
    }
    $prixTotalPaiement = $prixTotalPanier + $prixLivraison;
 ?>

<!DOCTYPE html>
<html>
	<head>
		<title>Paiement</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" href="Images/favicon.ico" type="images/x-icon">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

		<link rel="stylesheet" href="Styles/style.css">
		<link rel="stylesheet" href="Styles/MyFooter.css">
		<link rel="stylesheet" href="Styles/bootstrap.min.css">  <!-- Cette fiche de style n'est pas dans le dossier Styles : elle est importante ? -->
		<link rel="stylesheet" href="Styles/nav_bar.css">
		<link rel="stylesheet" type="text/css" href="Styles/paiement.css">
	</head>

	<body>	
	<!-- 00 -->
	<!-- TOP -->
	<!-- 00 -->
		
		<nav class="navbar navbar-expand-md" role="main" >
            <?php echo '<a class="navbar-brand" href="'.(($typeConnected == 3)?"accueil_vendeur.php":"accueil_client.php").'" style="margin-right: 15%;">'; ?>
                <img src="Images/logo.png" alt="" style="max-width: 150px;">
            </a>
            <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#main-navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse text-center" style="width: 50%;">
                <h1 style="margin: 0 auto;">Bienvenue sur Ebay-ECE</h1>
            </div>
            <div class="collapse navbar-collapse" id="main-navigation" style="width: 25%">
                <div class="row">
                    <form action="" method="post" class="form-inline text-center">
                        <div class="col-12 text-right">
                                <?php 
                                	echo '<input type="'.(($typeConnected == 1)?"hidden":"submit").'" name="boutonCompte" value="Mon compte" class="btn btn-default" style="font-size: 1.5em;display:inline-block; margin-right: 10px;">';
                                 ?>
                                <?php 
                                	echo '<input type="submit" name="toggleConnexion" value="'.(($typeConnected == 1)?"Connexion":"Déconnexion").'" class="btn btn-danger" style="border: 1.5px solid black;display:inline-block;">';
                                 ?>
                        </div>
                        <div class="col-12 text-center">
                            <?php echo ($typeConnected == 1)?"":
                                '<a class="nav-link" href="panier.php">
                                    <img style="max-width:100px;" src="Images/paniers.png">
                                </a>';
                             ?>
                        </div>
                    </form>
                </div>

            </div>
        </nav>

        <div class="navbar sticky-top" role="sub" >
            <?php echo '<a href="'.(($typeConnected == 3)?"accueil_vendeur.php":"accueil_client.php").'">Accueil</a>'; ?>
            <div class="subnav">
                <?php 
					echo '<input type="button" name="boutonCategories" onclick="location.href='.(($typeConnected == 3)?'\'categories_vendeur.php\'':'\'categories_client.php\'').';" class="subnavbtn" value="Catégories">';
                ?>
                <div class="subnav-content">
                    <?php 
                    	echo '<a href="'.(($typeConnected == 3)?"page_catalogue_vendeur.php":"page_catalogue_client.php").'?categorieProduit=1">'; 
                    ?>
                	Ferrailles ou Trésors</a>
                    <?php 
                    	echo '<a href="'.(($typeConnected == 3)?"page_catalogue_vendeur.php":"page_catalogue_client.php").'?categorieProduit=2">'; 
                    ?>
                	Bon pour le Musée</a>
                    <?php 
                    	echo '<a href="'.(($typeConnected == 3)?"page_catalogue_vendeur.php":"page_catalogue_client.php").'?categorieProduit=3">'; 
                    ?>
                	Accessoires VIP</a>  
                </div>
            </div>
            <div class="subnav">
                <button class="subnavbtn">Achats<i class="fa fa-caret-down"></i></button>
                <div class="subnav-content">
                    <?php 
                    	echo '<a href="'.(($typeConnected == 3)?"enchere_vendeur.php":"enchere_client.php").'">';
                    ?>
                	Enchères</a>
                    <?php 
                    	echo '<a href="'.(($typeConnected == 3)?"negoce_vendeur.php":"negoce_client.php").'">'; 
                    ?>
                	Négociations</a>
                </div>
            </div>              
        </div>

		<div id="wrapperGeneral">
			<div>
				<h1 id="titrePrincipal" align="center"><strong>Finalisation du paiement</strong></h1>
			</div>
			<div class="row" id="wrapperInterieur">
                
				<div class="col-md-6 col-sm-12">
                    <?php echo '<form id="formPaiement" action="paiement.php?typePaiement='.$typePaiement.''.(isset($produitPaye)?"&produitPaye=".$produitPaye:"").'" method="post">'; ?>
    					<div class="row" id="infosClient" style="height: auto;">
    						<div class="col-12 container-fluid">
    							<h3 style="margin-bottom: 15px;">Informations de livraison</h3>
    							<div class="row text-left" style="margin-bottom: 10px;">
    								<p class="col-12">
    									Nom : <input class="zoneInfo" type="text" name="Nom" style="width: 130px;" value="">
    									Prenom : <input class="zoneInfo" type="text" name="Prenom" style="width: 130px;" value="">
    								</p>
    							</div>
    							<div class="row text-left" style="margin-bottom: 10px;">
    								<p class="col-12">
    									Adresse ligne 1 : <input class="zoneInfo" type="text" name="AdresseLigne1" style="width: 180px;" value="">
    									Adresse ligne 2 : <input class="zoneInfo" type="text" name="AdresseLigne2" style="width: 180px;" value="">
    								</p>
    							</div>
    							<div class="row text-left" style="margin-bottom: 10px;">
    								<p class="col-12">
    									Ville : <input class="zoneInfo" type="text" name="Ville" style="width: 200px;" value="">
    									Code postal : <input class="zoneInfo" type="text" name="CodePostal" style="width: 75px;" value="">
    								</p>
    							</div>
    							<div class="row text-left" style="margin-bottom: 10px;">
    								<p class="col-12">
    									Pays : <input class="zoneInfo" type="text" name="Pays" style="width: 120px;" value="">
    									Numéro de téléphone : <input class="zoneInfo" type="text" name="NumeroTelephone" style="width: 100px;" value="">
    								</p>
    							</div>
    						</div>
    					</div>
    					<div class="row" id="infosCarte" style="height: auto;">
    						<div class="col-12 container-fluid">
    							<div class="row text-left" id="teteInfoCarte" style="margin-bottom: 15px;">
    								<h3 style="margin-bottom: 15px;">Informations de paiement</h3>
    								<input type="submit" name="InformationsCarteAuto" class="btn btn-sm btn-info col-lg-4 col-md-12" style="white-space: normal;" value="Insérer les informations de paiement enregistrées">
    							</div>
    							<div class="row text-left" style="margin-bottom: 10px;">
    								<p class="col-12">
    									Type de carte: 
    									<label class="radio-inline">
    								      	<input type="radio" name="optradio" checked>Visa
    								    </label>
    								    <label class="radio-inline">
    								      	<input type="radio" name="optradio">Mastercard
    								    </label>
    								    <label class="radio-inline">
    								      	<input type="radio" name="optradio">American Express
    								    </label>
    								</p>
    							</div>
    							<div class="row text-left" style="margin-bottom: 10px;">
    								<p class="col-12">
    									Numéro de la carte : <input class="zoneInfo" type="text" name="NumeroCarte" style="width: 150px;" value="">
    									Titulaire : <input class="zoneInfo" type="text" name="Prenom" style="width: 150px;" value="">
    								</p>
    							</div>
    							<div class="row text-left" style="margin-bottom: 10px;">
    								<p class="col-12">
    									Date d'expiration : <input class="zoneInfo" type="text" name="MoisExpiration" style="width: 35px;margin-right: 0px;" value="MM"> / <input class="zoneInfo" type="text" name="AnneeExpiration" style="width: 35px;" value="AA">
    									Code de sécurité : <input class="zoneInfo" type="text" name="CodeSecurite" style="width: 55px;" value="">
    								</p>
    							</div>
    						</div>
    					</div>
                    </form>
				</div>

				<div class="col-lg-1 col-md-1 col-xs-12" style="height: 30px;"></div>
				<div class="col-md-5 col-sm-12">
					<div class="row" style="height: auto;">
						<div class="text-center" id="recap">
							<p>Prix des produits : <strong><?php echo $prixTotalPanier." €"; ?></strong></p><br>
							<p>Coût de la livraison : <strong><?php echo $prixLivraison." €"; ?></strong></p><br>
							<p>Total : <strong><?php echo $prixTotalPaiement." €"; ?></strong></p>
						</div>
					</div>
					<?php 
                        if($prixTotalPaiement == $prixLivraison){       //Il y a eu une erreur lors de la récupération des données et le prix des produits vaut 0
                            echo "Il y a eu une erreur dans le calcul du prix";
                        }else{
                            echo '
                                <div class="row text-center" style="height: 50%;">
                                    <input form="formPaiement" type="submit" name="boutonPayer" class="btn btn-warning btn-lg col-9 center" id="boutonPayer" value="Payer">
                                </div>
                            ';
                        }
                     ?>
				</div>
			</div>
		</div>
	
	<!-- 00 -->
	<!-- FOOTER -->
	<!-- 00 -->

    	<footer class="page-footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-12 text-center">
                        <h3>Page</h3>
                        <ul>
                            <li>
                            	<?php 
                            		echo '<a href="'.(($typeConnected == 3)?"accueil_vendeur.php":"accueil_client.php").'">';
                            	?>
                            	Accueil</a>
                            </li>
                            <li>
                            	<?php 
                            		echo '<a href="'.(($typeConnected == 3)?"profil_vendeur_prive.php":(($typeConnected == 2)?"profil_client.php":"page_de_connexion.php")).'">';
                            	?>
                            	Mon compte</a>
                            </li>
                            <li>
                            	<?php 
                            		echo '<a href="'.(($typeConnected == 3)?"categories_vendeur.php":"categories_client.php").'">';
                            	?>
                            	Acheter</a>
                            </li>
                            <li>
                            	<?php 
                            		echo '<a href="'.(($typeConnected == 3)?"infos_vendeur.php":"infos_client.php").'">';
                            	?>
                            	Conditions d&#39;utilisation</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4 col-sm-12 text-center">
                        <h3>Partenaires</h3>
                        <ul>
                            <li><img src="Images/ECE.png"/></li><br>
                            <li><img src="Images/ECE_Tech.png"/></li>
                        </ul>
                    </div>
                    <div class="col-md-4 col-sm-12 text-center">
                          <h3>Nous contacter</h3>
                         <ul>
                            <li><a href="mailto:aurele.duparc@edu.ece.fr">aurele.duparc@edu.ece.fr</a><br></li>
                            <li><a href="#">+33 1 23 45 67 89</a><br></li>
                            <li><a href="#">37 Quai de Grenelle<br>
                            Immeuble POLLUX<br>
                            75015 Paris</a></li>
                        </ul>
                     </div>
                </div>
                <div class="footer-copyright text-center">Copyright &copy; 2020 <strong>Ebay ECE</strong></div>
            </div>
        </footer>
	</body>

	
</html>