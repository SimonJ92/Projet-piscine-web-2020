<!DOCTYPE html>
<html>
	<head>
		<title>Enchère</title>
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
		<link rel="stylesheet" type="text/css" href="Styles/enchere_client.css">
		<script src="Scripts/enchere_client.js"></script>
		<link rel="icon" href="Images/favicon.ico" type="images/x-icon">
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
	
	<!-- 00 -->
	<!-- ENTRESITE -->
	<!-- 00 -->
	
	<div class="wrapper">
		<div class="produit_now">
			<ul class="list-unstyled">
				<li class="media">
					<a href="#"><img class="mr-3" src="..." alt="Generic placeholder image"></a>
					<div class="media-body">
						<h5 class="mt-0 mb-1">List-based media object</h5>
							Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
					</div>
				</li>
				<li class="media my-4">
					<a href="#"><img class="mr-3" src="..." alt="Generic placeholder image"></a>
					<div class="media-body">
						<h5 class="mt-0 mb-1">List-based media object</h5>
							Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
					</div>
				</li>
				<li class="media">
					<a href="#"><img class="mr-3" src="..." alt="Generic placeholder image"></a>
					<div class="media-body">
						<h5 class="mt-0 mb-1">List-based media object</h5>
						Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
					</div>
				</li>
				<li class="media">
					<a href="#"><img class="mr-3" src="..." alt="Generic placeholder image"></a>
					<div class="media-body">
						<h5 class="mt-0 mb-1">List-based media object</h5>
						Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
					</div>
				</li>
				<li class="media">
					<a href="#"><img class="mr-3" src="..." alt="Generic placeholder image"></a>
					<div class="media-body">
						<h5 class="mt-0 mb-1">List-based media object</h5>
						Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
					</div>
				</li>
			</ul>
		</div>
		<div class="information">
			<div class="row">
				<div class="col-lg-6">
					<a href="#"><h3><b>Nom du produit</b></h3></a>
				</div>
				<div class="col-lg-6">
					<h3>Catégorie du produit</h3>
				</div>
				<div class="col-lg-3" style="background-color:inherit"></div>
			</div>
			<div class="row">
				<div class="col-lg-3" id="ok">
				<a href="#"><img class="imageProduit center" src="Images/logo.png"></a>
				</div>
				<div class="col-lg-8" style="background-color:white">
				<h3>Description</h3>
				<p>Blabla Blabla Blabla Blabla Blabla Blabla Blabla Blabla Blabla Blabla Blabla Blabla Blabla Blabla Blabla Blabla Blabla </p>
				</div>
			</div>
			<div class="row">
				<br><p></p><br><br>
			</div>
			<div class="information_vendeur">
				<div class="row">
					<div class="col-sm-2" style="background-color:inherit"></div>
					<div class="col">
						<a href="#"><h3>Vendeur</h3></a>
					</div>
					<div class="col">
						<a href="#"><h3>Lien vers le site du vendeur</h3></a>
					</div>
				</div>
			</div>
		</div>
		
		<div class="container">
		<div class="container-fluid">
			<div class="col-lg-9">
				<h3>L'enchère se terminera le :</h3>
				<p id="DateE"></p> 
			</div>
			<div class="col-lg-3" style="background-color:white"></div>
			<div class="col-lg-5">
				<h3> Fin enchère dans : <br> </h3>
				<p id="dateenchere"></p>
			</div>
		</div>
		<div class="container-fluid">
			<div class="col-lg-9">
				<div id="divencheredisabled">
				<h3>Mon enchère</h3>
				<form>
					<fieldset disabled>
						<div class="form-group">
							<label for="enchere">Mon enchère: </label>
							<input type ="text" class="form-control" id="encheredisabled" name="enchere" placeholder="Saisir votre enchère">
							<small class="form-text text-muted">Attention une seule enchère maximale possible.</small>
						</div>
					</fieldset>
				</form>
				</div>
				<div id="divenchere" style="display:none">
				<h3>Mon	enchère </h3>
				<form>
					<div class="form-group">
							<label for="enchere">Mon enchère: </label>
							<input type ="text" class="form-control" id="enchere" name="enchere" placeholder="Saisir votre enchère">
							<small class="form-text text-muted">Attention une seule enchère maximale possible.</small>
					</div>
				</form>
				</div>
			</div>
			<div class="col-lg-3" style="background-color:white"></div>
			<div class="col-lg-5">
				<div class="row">
					<div class="col">
						<a href="#"><button class="btn btn-block btn-success" >Acheter Maintenant </button></a>
					</div>
					<div class="col">
						PRIX : 
						<p id="prix"></p>
					</div>
				</div>
			</div>
		</div>
		</div>
		<div class="container-fluid">
		<h3>Règlement des enchères </h3>
		<p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec neque congue, suscipit turpis quis, viverra turpis. Vivamus mollis ipsum vel luctus blandit. Integer ultrices blandit augue nec elementum. Ut accumsan eros quis diam vehicula, at ultricies magna dictum. Sed vel euismod sem. Duis ut bibendum ex. Duis sit amet nisi tempus elit vulputate ullamcorper sed sit amet sem. Sed imperdiet enim ac efficitur fermentum. Donec enim urna, sollicitudin id mattis fermentum, tempus quis metus. Donec sed diam lobortis, sagittis nisl in, fringilla risus. Mauris vel augue in massa porttitor convallis. Etiam lacinia maximus libero. Nam volutpat, risus lobortis scelerisque rhoncus, ex purus faucibus nunc, quis ultrices ante nisl ac ligula. Donec ac feugiat nunc, eu blandit libero. Phasellus ligula justo, luctus ac elit a, semper porttitor nibh. Proin sollicitudin ut felis vitae bibendum. </p>
		<form>
			<div class="form-group">
				<div class="form-check">
					<input class="form-check-input" type="checkbox" id="gridCheck" onChange="afficheenchere(gridCheck)">
					<label class="form-check-label" for="gridCheck">
								Je certifie avoir pris connaissance des conditions d'utilisations.
					</label>
				</div>
			</div>
		</form>
					
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