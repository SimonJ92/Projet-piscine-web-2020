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
	if(isset($_POST["boutonSupprimer"])){
		if($_POST["boutonSupprimer"] && $db_found){
			$numeroSupprimer = isset($_POST["numeroSupprimer"])?$_POST["numeroSupprimer"]:"";
			if($numeroSupprimer == ""){
				echo "le pseudo n'a pas été transmis";
			}else{
				$sqlSupprimer = "DELETE from panier where NumeroProduit =".$numeroSupprimer;
				$resultDelete = mysqli_query($db_handle,$sqlSupprimer) or die (mysqli_error($db_handle));
			}
		}
	}

    $panierVide = 1;
 ?>

<!DOCTYPE html>
<html>
	<head>
		<title>Mon panier</title>
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
		<link rel="stylesheet" type="text/css" href="Styles/panier.css">
		<link rel="stylesheet" href="Styles/nav_bar.css">
	</head>

	<body>	
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
	
		<div class="container-fluid">
			<div class="row" id="contenu">
				<div id="conteneurListe" class="col-lg-8 col-md-7 col-xs-12">
					<div class="row text-center"><h2 class="col-12">Mon Panier</h2></div>
					<div class="row">
						<div id="listeProduits" class="col-11 container-fluid">


							<?php 
								if ($db_found) {
									$sqlPanier = "SELECT * from panier where IDClient like '%$idConnected%'";
									$resultPanier = mysqli_query($db_handle,$sqlPanier);
									if (mysqli_num_rows($resultPanier) == 0) {
										echo "Votre panier est vide";
                                        $panierVide=1;
									}else{
                                        $panierVide=0;
										while ($dataPanier = mysqli_fetch_assoc($resultPanier)) {
											$sqlProduit = "SELECT * from produit where Numero =".$dataPanier["NumeroProduit"];	//on pourrait transformer les 2 requêtes en 1 seule
											$resultProduit = mysqli_query($db_handle,$sqlProduit);
											if(mysqli_num_rows($resultProduit) == 0){
												echo "Produit non trouvé";
											}else
											{
												$dataProduit = mysqli_fetch_assoc($resultProduit);
												echo '
													<div class="produit">
														<div class="row" style="height: auto;">
															<div class="col-md-3 col-sm-12 img-fluid" style="height: 200px;">
																<a href="produit_client.php?numeroProduit='.$dataProduit["Numero"].'"><img class="imageProduit center"src="'.$dataProduit["Photo1"].'"></a>
															</div>
															<div class="col-md-6 col-sm-12" >
																<div class="row nomProduit text">
																		<a href="produit_client.php?numeroProduit='.$dataProduit["Numero"].'"><b>'.$dataProduit["Nom"].'</b></a>
																</div>
																<div class="row descriptionProduit">
																	'.$dataProduit["DescriptionCourte"].'
																</div>
															</div>
															<div class="col-md-3 col-sm-12">
																<div class="row prixProduit">
																	<div class="container">
																		<h6 class="col-md-12 text-center">Prix d\'achat immédiat</h6>
																		<p class="prix text-center"><span>'.$dataProduit["PrixDirect"].'</span>€</p>
																	</div>
																</div>
																<div class="row supprimerProduit">
																	<form action="panier.php" method="post">
																		<input type="hidden" name="numeroSupprimer" value="'.$dataProduit["Numero"].'">
																		<input type="submit" name="boutonSupprimer" class="btn btn-danger col-md-12 btn-lg" value="Supprimer du panier">
																	</form>
																</div>
															</div>
														</div>
														<div class="row autreOption">
															<h6 class="col-lg-3 col-md-4 col-sm-12">Autre option d\'achat :</h6>
															<a href="'.(($dataProduit["MethodeVente"] == "Encheres")?"enchere_client.php?numeroProduit=".$dataProduit["Numero"]:(($dataProduit["MethodeVente"] == "Negoce")?"negoce_client.php?numeroProduit=".$dataProduit["Numero"]:"!")).'" class="btn btn-info btn-lg col-md-6 col-sm-12" role="button" style="height: 50px; margin-bottom: 5px;">
																<p class="center">'.$dataProduit["MethodeVente"].'</p>
															</a>
														</div>
													</div>
												';
											}
										}
									}
								}
							 ?>
						

						</div>
					</div>
				</div>
				<div class="col-lg-1 col-md-1 col-xs-12" style="height: 30px; background-color: inherit;"></div>
				<div id="recap"	class="col-lg-3 col-md-4 col-xs-12">
					<div class="container-fluid">
						<p><h3 align="center"><strong>Récapitulatif</strong></h3></p>
						<div class="row">
							<?php 
								$sqlNbObjets = "SELECT count(*) as nbObjets from panier where IDClient =".$idConnected;
								$resultCount = mysqli_query($db_handle,$sqlNbObjets);
								if (mysqli_num_rows($resultCount) == 0) {
									echo "erreur comptage objets";
								}else{
									$dataCount = mysqli_fetch_assoc($resultCount);
									echo '
										<p>Nombre d\'objets</p>
										<p><span id="NombreObjets">'.$dataCount["nbObjets"].'</span></p>
									';
								}
							 ?>
						</div>
						<div class="row">
							<?php 
								$sqlTotalPrix = "SELECT Sum(A.PrixDirect) as totalPrix from produit A join panier B on A.Numero = B.NumeroProduit where B.IDClient =".$idConnected;
								$resultTotalPrix = mysqli_query($db_handle,$sqlTotalPrix);
								if (mysqli_num_rows($resultTotalPrix) == 0) {
									echo "erreur comptage du prix total";
								}else{
									$dataTotalPrix = mysqli_fetch_assoc($resultTotalPrix);
									echo '
										<p>Prix total :</p>
										<p><span id="prixTotal">'.$dataTotalPrix["totalPrix"].'</span> €</p>
									';
								}
							 ?>
						</div>
						<br>
						<div class="row" id="valider">
							<div class="col-12">
								<?php echo ($panierVide)?"":'<a href="paiement.php?typePaiement=1" class="btn btn-warning col-12 btn-lg" role="button">Valider le panier</a>'; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

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