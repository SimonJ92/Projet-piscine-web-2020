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
		<title>Produit Vendeur</title>
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
		<link rel="stylesheet" href="Styles/produit_vendeur.css">
		<script src="Scripts/produit_vendeur.js"></script>
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
		<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
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
						<div class="col-12 text-center">
								<input type="submit" name="boutonCompte" value="Mon compte" class="btn btn-default" style="font-size: 1.5em;display:inline-block; margin-right: 10px;">
								<input type="submit" name="toggleConnexion" value="Connexion" class="btn btn-danger" style="border: 1.5px solid black;display:inline-block;">
						</div>
							<input type="submit" name="lienAdmin" value="Admin" class="col-12 btn btn-warning btn-lg" style="border: 1.5px solid black;margin-top: 20px;" align="center">
					</form>
				</div>
			</div>
		</nav>

		<div class="navbar sticky-top" role="sub" >
			<a href="#accueil">Accueil</a>
			<a href="#mesProduits">Mes Produits</a>
			<div class="subnav">
				<button class="subnavbtn">Catégories<i class="fa fa-caret-down"></i></button>
				<div class="subnav-content">
					<a href="#ferrailles">Ferrailles ou Trésors</a>
					<a href="#musee">Bon pour le Musée</a>
					<a href="#vip">Accessoires VIP</a>	
				</div>
			</div>
			<div class="subnav">
				<button class="subnavbtn">Ventes<i class="fa fa-caret-down"></i></button>
				<div class="subnav-content">
					<a href="#encheres">Enchères</a>
					<a href="#negociations">Négociations</a>
				</div>
			</div> 				
		</div>


	<!-- 00 -->
	<!-- DIV -->
	<!-- 00 -->
	<div class="wrapper">
		<div class="image">
			<p>Image Produit 1</p>
		</div>
		<div class="descrip">
			<h2> <b> Nom du produit</b> </h2>
			<p>Description brève du produit 1 Description brève du produit 1 Description brève du produit 1 Description brève du produit 1 Description brève du produit 1 Description brève du produit 1 Description brève du produit 1 Description brève du produit 1 Description brève du produit 1 Description brève du produit 1 Description brève du produit 1 Description brève du produit 1 Description brève du produit 1 Description brève du produit 1 Description brève du produit 1 Description brève du produit 1 Description brève du produit 1 Description brève du produit 1 Description brève du produit 1 Description brève du produit 1 Description brève du produit 1 Description brève du produit 1 Description brève du produit 1 Description brève du produit 1 Description brève du produit 1 Description brève du produit 1 Description brève du produit 1 Description brève du produit 1 </p>
		</div>
		<div class="vendeur">
			<p>Vendeur A</p>
		</div>
		<div class="lienvendeur">
			<p>Lien vers la page du vendeur A</p>
		</div>
	
		<div class="option">
			<!-- <p>Options d'achat</p> -->
			<div class="col text-center">
				<button class="btn btn-block btn-primary" disabled>Achat Direct</button> <br><br>
				<button class="btn btn-block btn-primary" disabled>Voir aux enchères</button> <br><br>
				<button class="btn btn-block btn-primary" disabled>Proposer une meilleure offre</button> <br><br>
			</div>
		</div>
		
		<div class="suppr"> 
		<!-- Attention le client ne peut pas supprimer de produit -->
			<!-- <p>Bouton pour supprimer le produit de la base de données</p> -->
			<button class="btn btn-sm btn-block btn-danger" onclick="validation()">Supprimer le produit de la vente</button>
		</div>
		
		<div class="simili">
			<h3>Autres produits du vendeur</h3>
			<div class="row">
				<div class="col-4">
					<div id="carrousel">
					<ul>
						<li><img src="Images/imageFeraille.png" width="200" height="200" /></li>
						<li><img src="Images/imageVIP.png" width="200" height="200" /></li>
						<li><img src="Images/imageMusee.png" width="200" height="200" /></li>
					</ul>
					<br>
					</div>
				</div>
				<div class="col-4">
					<div id="carrousel2">
					<ul>
						<li><img src="Images/imageMusee.png" width="200" height="200" /></li>
						<li><img src="Images/imageFeraille.png" width="200" height="200" /></li>
						<li><img src="Images/imageVIP.png" width="200" height="200" /></li>
					</ul>
					<br>
					</div>
				</div>
				<div class="col-4">
					<div id="carrousel3">
					<ul>
						<li><img src="Images/imageVIP.png" width="200" height="200" /></li>
						<li><img src="Images/imageMusee.png" width="200" height="200" /></li>
						<li><img src="Images/imageFeraille.png" width="200" height="200" /></li>
					</ul>
					<br>
					</div>
				</div>
			</div>
		</div>
		
		<div class="fulldescrip">
			<p>Description complète<p>
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