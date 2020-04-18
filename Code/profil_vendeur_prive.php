<!DOCTYPE html>
<html>
	<head>
		<title>Profil du vendeur</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" href="Images/favicon.ico" type="images/x-icon">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
		 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="Styles/style.css">
		<link rel="stylesheet" type="text/css" href="Styles/myFooter.css">
		<link rel="stylesheet" type="text/css" href="Styles/bootstrap.min.css">		<!-- Cette fiche de style n'est pas dans le dossier Styles : elle est importante ? -->
		<link rel="stylesheet" href="Styles/nav_bar.css">
		<link rel="stylesheet" type="text/css" href="Styles/profil-vendeur-prive.css">
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

	
		<div class="container-fluid" id="conteneur" style="background-image: url('Images/fond-profil1.jpg');">
			<div class="row container-fluid" id="contenu">
				<div class="row" id="infosVendeur">
					<div class="col-md-4 col-sm-12 conteneurImage" style="height: 300px">
						<img id="photoVendeur" src="Images/photo-vendeur1.jpg" class="imagesExemples">
						<button id="changerImage" class="btn btn-warning col-12">Changer l'image de profil</button>
					</div>
					<div class="col-md-1 col-sm-12" style="height: 50px;"></div>
					<div class="col-md-7 col-sm-12" id="infosTexte">
						<div class="container-fluid" style="height: 100%">
							<div class="row" id="nomVendeur" style="height:auto;">
								Pseudo : <textarea class="col-12" rows="2">Nom du vendeurNom du vendeurNom du vendeurNom du vendeurNom du vendeurNom du vendeurNom du vendeurNom du vendeurNom du vendeurNom du vendeurNom du vendeurNom du vendeurNom du vendeurNom du vendeurNom du vendeurNom du vendeurNom du vendeurNom du vendeurNom du vendeurNom du vendeurNom du vendeurNom du vendeurNom du vendeurNom du vendeur</textarea>
							</div>
							<div class="row" id="description">
								Description : <textarea rows="6">Description du vendeurDescription du vendeurDescription du vendeurDescription du vendeurDescription du vendeurDescription du vendeurDescription du vendeurDescription du vendeurDescription du vendeurDescription du vendeurDescription du vendeurDescription du vendeurDescription du vendeurDescription du vendeurDescription du vendeurDescription du vendeurDescription du vendeurDescription du vendeurDescription du vendeurDescription du vendeurDescription du vendeurDescription du vendeurDescription du vendeurDescription du vendeur
								</textarea>
							</div>
							<div class="row">
								<button class="btn btn-warning col-12" id="sauverInfosTexte">
									Sauvegarder les informations
								</button>
							</div>
						</div>
					</div>
				</div>

				<div class="row text-center"><button id="changerImageFond" class="btn btn-warning col-12">Changer l'image de fond</button></div>

				<div class="row" id="exemplesProduits">
					<div class="col-md-3 col-sm-12 conteneurImage">
						<a href="#"><img src="Images/imageMusee.png" class="imagesExemples"></a>
					</div>
					<div class="col-md-3 col-sm-12 conteneurImage">
						<a href="#"><img src="Images/imageFeraille.png" class="imagesExemples"></a>
					</div>
					<div class="col-md-3 col-sm-12 conteneurImage">
						<a href="#"><img src="Images/imageVIP.png" class="imagesExemples"></a>
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
	                        <li><a href="#">Accueil</a></li>
	                        <li><a href="#">Mon compte</a></li>
	                        <li><a href="#">Vendre</a></li>
	                        <li><a href="#">Conditions d&#39;utilisation</a></li>
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