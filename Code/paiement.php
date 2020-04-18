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
	                        <li><a href="#">Accueil</a></li>
	                        <li><a href="#">Mon compte</a></li>
	                        <li><a href="#">Acheter</a></li>
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