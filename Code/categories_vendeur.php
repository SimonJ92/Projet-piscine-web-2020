<!DOCTYPE html>
<html>
	<head>
		<title>Catégories</title>
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
		<link rel="stylesheet" type="text/css" href="Styles/categories.css">
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
				<button class="subnavbtn">Achats<i class="fa fa-caret-down"></i></button>
				<div class="subnav-content">
					<a href="#encheres">Enchères</a>
					<a href="#negociations">Négociations</a>
				</div>
			</div> 				
		</div>

	
		<div class="container-fluid features">
		<h1 class="text-center"><strong>Catégories</strong></h1>
		<div class="row">
			<div class="col-md-4 col-sm-12 text-center">
				<a href="#">									<!-- Lien vers la page catalogue de la catégorie en question -->
					<h2>Ferraille et trésors</h2>
					<img src="Images/imageFeraille.png" alt="imageFeraille" class="img-fluid">
				</a>
			</div>
			<div class="col-md-4 col-sm-12  text-center">
				<a href="#">									<!-- Lien vers la page catalogue de la catégorie en question -->
					<h2>Bon pour le musée</h2>
					<img src="Images/imageMusee.png" alt="imageMusee" class="img-fluid">
				</a>
			</div>
			<div class="col-md-4 col-sm-12 text-center">
				<a href="#">									<!-- Lien vers la page catalogue de la catégorie en question -->
					<h2>Accessoires VIP</h2>
					<img src="Images/imageVIP.png" alt="imageVIP" class="img-fluid">
				</a>
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