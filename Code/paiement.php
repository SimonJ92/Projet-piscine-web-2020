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

    $produitPaye = isset($_GET["produit"])?$_GET["produit"]:"";
    //id du produit, si originaire d'enchères ou négoce
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
								<button class="btn btn-sm btn-info col-lg-4 col-md-12" style="white-space: normal;">Insérer les informations de paiement enregistrées</button>
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
				</div>
				<div class="col-lg-1 col-md-1 col-xs-12" style="height: 30px;"></div>
				<div class="col-md-5 col-sm-12">
					<div class="row" style="height: auto;">
						<div class="text-center" id="recap">
							<p>Prix des produits : <strong>200000.00€</strong></p><br>
							<p>Coût de la livraison : <strong>20.00€</strong></p><br>
							<p>Total : <strong>200020.00€</strong></p>
						</div>
					</div>
					<div class="row text-center" style="height: 50%;">
						<button class="btn btn-warning btn-lg col-9 center" id="boutonPayer">
							Payer
						</button>
					</div>
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