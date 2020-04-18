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
	<!-- 00 -->
	<!-- TOP -->
	<!-- 00 -->
		
		<nav class="navbar navbar-expand-md" role="main" >
			<a class="navbar-brand" href="#" style="margin-right: 15%;">
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
								<input type="submit" name="boutonCompte" value="Mon compte" class="btn btn-default" style="font-size: 1.5em;display:inline-block; margin-right: 10px;">
								<input type="submit" name="toggleConnexion" value="Connexion" class="btn btn-danger" style="border: 1.5px solid black;display:inline-block;">
						</div>
						<div class="col-12 text-center">
							<a class="nav-link" href="#">
								<img style="max-width:100px;" src="Images/paniers.png" alt="">
							</a>
						</div>
					</form>
				</div>

			</div>
		</nav>

		<div class="navbar sticky-top" role="sub" >
			<a href="#accueil">Accueil</a>
			<div class="subnav">
				<button class="subnavbtn">Catégories<i class="fa fa-caret-down"></i></button>
				<div class="subnav-content">
					<a href="#ferrailles">Ferrailles ou Trésors</a>
					<a href="#musee">Bon pour le Musée</a>
					<a href="#vip">Accessoires VIP</a>	
				</div>
			</div>
			<div class="subnav">
				<button class="subnavbtn">Achats<i class="fa fa-caret-down"></i></button>
				<div class="subnav-content">
					<a href="#encheres">Enchères</a>
					<a href="#negociations">Négociations</a>
				</div>
			</div> 				
		</div>
	
		<div class="container-fluid">
			<div class="row" id="contenu">
				<div id="conteneurListe" class="col-lg-8 col-md-7 col-xs-12">
					<div class="row text-center"><h2 class="col-12">Mon Panier</h2></div>
					<div class="row">
						<div id="listeProduits" class="col-11 container-fluid">



							<div class="produit">
								<div class="row" style="height: auto;">
									<div class="col-md-3 col-sm-12 img-fluid" style="height: 200px;">
										<a href="#"><img class="imageProduit center"src="Images/imageMusee.png"></a>
									</div>
									<div class="col-md-6 col-sm-12" >
										<div class="row nomProduit text">
												<a href="#"><b>Nuit de neige à Kambara, HiroshigeNuit de neige à Kambara, HiroshigeNuit de neige à Kambara, HiroshigeNuit de neige à Kambara, Hiroshige</b></a>
										</div>
										<div class="row descriptionProduit">
											Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque interdum quam odio, quis placerat ante luctus eu. Sed aliquet dolor id sapien rutrum, id vulputate quam iaculis. Suspendisse consectetur mi id libero fringilla, in pharetra sem ullamcorper. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque interdum quam odio, quis placerat ante luctus eu. Sed aliquet dolor id sapien rutrum, id vulputate quam iaculis. Suspendisse consectetur mi id libero fringilla, in pharetra sem ullamcorper.
										</div>
									</div>
									<div class="col-md-3 col-sm-12">
										<div class="row prixProduit">
											<div class="container">
												<h6 class="col-md-12 text-center">Prix d'achat immédiat</h6>
												<p class="prix text-center"><span>120000.00</span>€</p>
											</div>
										</div>
										<div class="row supprimerProduit">
											<a href="#" class="btn btn-danger col-md-12 btn-lg" role="button">
												<p class="center">Supprimer du panier</p>
											</a>
										</div>
									</div>
								</div>
								<div class="row autreOption">
									<h6 class="col-lg-3 col-md-4 col-sm-12">Autre option d'achat :</h6>
									<a href="#" class="btn btn-info btn-lg col-md-6 col-sm-12" role="button" style="height: 50px; margin-bottom: 5px;">
										<p class="center">Enchère</p>
									</a>
								</div>
							</div>







						</div>
					</div>
				</div>
				<div class="col-lg-1 col-md-1 col-xs-12" style="height: 30px; background-color: inherit;"></div>
				<div id="recap"	class="col-lg-3 col-md-4 col-xs-12">
					<div class="container-fluid">
						<p><h3 align="center"><strong>Récapitulatif</strong></h3></p>
						<div class="row">
							<p>Nombre d'objets</p>
							<p><span id="NombreObjets">0</span></p>
						</div>
						<div class="row">
							<p>Prix total :</p>
							<p><span id="prixTotal">0.00</span> €</p>
						</div>
						<br>
						<div class="row" id="valider">
							<div class="col-12">
								<a href="#" class="btn btn-warning col-12 btn-lg" role="button">Valider le panier</a>
							</div>
						</div>
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