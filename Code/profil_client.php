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
		<title>Page d'accueil Ebay ECE</title>
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
		<link rel="stylesheet" href="Styles/page_client.css">
		<script src="Scripts/script_pageclient.js" type="text/javascript" ></script>
		<style>
body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  -webkit-animation-name: fadeIn; /* Fade in the background */
  -webkit-animation-duration: 0.4s;
  animation-name: fadeIn;
  animation-duration: 0.4s
}

/* Modal Content */
.modal-content {
  position: fixed;
  bottom: 0;
  background-color: #fefefe;
  width: 100%;
  -webkit-animation-name: slideIn;
  -webkit-animation-duration: 0.4s;
  animation-name: slideIn;
  animation-duration: 0.4s
}

/* The Close Button */
.close {
  color: white;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

.modal-header {
  padding: 2px 16px;
  background-color: #5cb85c;
  color: white;
}

.modal-body {padding: 2px 16px;}

.modal-footer {
  padding: 2px 16px;
  background-color: #5cb85c;
  color: white;
}

/* Add Animation */
@-webkit-keyframes slideIn {
  from {bottom: -300px; opacity: 0} 
  to {bottom: 0; opacity: 1}
}

@keyframes slideIn {
  from {bottom: -300px; opacity: 0}
  to {bottom: 0; opacity: 1}
}

@-webkit-keyframes fadeIn {
  from {opacity: 0} 
  to {opacity: 1}
}

@keyframes fadeIn {
  from {opacity: 0} 
  to {opacity: 1}
}
</style>
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
	<!-- DIV -->
	<!-- 00 -->
	<div style="height: 1500px;">
		<!-- <div class="container"> -->
		<br>
			<!-- <button id="savebtn" class="btn btn-primary btn-lg btn-block">Sauvegarder les changements</button> -->
			<!-- </div> -->

			<!-- Trigger/Open The Modal -->
			<button id="myBtn" class="btn btn-primary btn-lg btn-block">Sauvegarder vos modifications</button>

			<!-- The Modal -->
			<div id="myModal" class="modal">

			<!-- Modal content -->
				<div class="modal-content">
					<div class="modal-header">
				
				<button id="Save" class="btn btn-warning" onclick="save()">VALIDER </button>
					</div>
						<div class="modal-body">
						<form>
							<h1>Informations</h1>
								<label for="prenom"><b>Prénom</b></label>
								<input type="text" id="prenom" name="prenom" required><br>

								<label for="nom"><b>Nom</b></label>
								<input type="text" id="nom" name="nom" required><br>

								<label for="mail"><b>Adresse Mail</b></label>
								<input type="text" id="mail" name="mail" required><br>

								<label for="adresse1"><b>Adresse 1</b></label>
								<input type="text" id="adresse1" name="adresse1" required><br>

								<label for="adresse2"><b>Adresse 2</b></label>
								<input type="text" id="adresse2" placeholder="NULL" name="adresse2" required><br>

								<label for="ville"><b>Ville</b></label>
								<input type="text" id="ville" name="ville" required><br>

								<label for="zip"><b>Code Postal</b></label>
								<input type="text" id="zip" name="zip" required><br>

								<label for="pays"><b>Pays</b></label>
								<input type="text" id="pays" name="pays" required><br>

								<label for="phone"><b>Téléphone</b></label>
								<input type="text" id="phone" name="phone" required>
						</div>
			<div class="modal-footer">
				
			</div>
				</div>

			</div>
			<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
		<br>
		<!-- </div> -->
		<div class="row" id="ensemble">
			<div class="col-sm-10" style="background-color:#aaa;">
				<h2>Prénom</h2>
				<p id="old_prenom">André</p>
			</div>
			<div class="col-sm-2" >
				<br>
				<button class="btn btn-success btn-lg btn-block" onclick="changement_prenom()">Modifier</button>
			</div>
		</div>
		<br>
		<div class="row" id="ensemble">
			<div class="col-sm-10" style="background-color:#aaa;">
				<h2>Nom</h2>
				<p id="old_nom">Breton</p>
			</div>
			<div class="col-sm-2" >
				<br>
				<button class="btn btn-success btn-lg btn-block" onclick="changement_nom()">Modifier</button>
			</div>
		</div>
		<br>
		<div class="row" id="ensemble">
			<div class="col-sm-10" style="background-color:#aaa;">
				<h2>Adresse Mail</h2>
				<p id="old_mail">andre.breton@edu.ece.fr</p>
			</div>
			<div class="col-sm-2">
				<br>
				<button class="btn btn-success btn-lg btn-block" onclick="changement_mail()">Modifier</button>
			</div>
		</div>
		<br>
		<div class="row" id="ensemble">
			<div class="col-sm-10" style="background-color:#aaa;">
				<h2>Adresse 1</h2>
				<p id="old_adresse1">10 Rue du Poète</p>
			</div>
			<div class="col-sm-2">
				<br>
				<button class="btn btn-success btn-lg btn-block" onclick="changement_adresse1()">Modifier</button>
			</div>
		</div>
		<br>
		<div class="row" id="ensemble">
			<div class="col-sm-10" style="background-color:#aaa;">
				<h2>Adresse 2</h2>
				<p id="old_adresse2">Appartement N°28</p>
			</div>
			<div class="col-sm-2">
				<br>
				<button class="btn btn-success btn-lg btn-block" onclick="changement_adresse2()">Modifier</button>
			</div>
		</div>
		<br>
		<div class="row" id="ensemble">
			<div class="col-sm-10" style="background-color:#aaa;">
				<h2>Ville</h2>
				<p id="old_ville">Tinchebray</p>
			</div>
			<div class="col-sm-2">
				<br>
				<button class="btn btn-success btn-lg btn-block" onclick="changement_ville()">Modifier</button>
			</div>
		</div>
		<br>
		<div class="row" id="ensemble">
			<div class="col-sm-10" style="background-color:#aaa;">
				<h2>Code Postal</h2>
				<p id="old_zip">61800</p>
			</div>
			<div class="col-sm-2">
				<br>
				<button class="btn btn-success btn-lg btn-block" onclick="changement_zip()">Modifier</button>
			</div>
		</div>
		<br>
		<div class="row" id="ensemble">
			<div class="col-sm-10" style="background-color:#aaa;">
				<h2>Pays</h2>
				<p id="old_pays">France</p>
			</div>
			<div class="col-sm-2">
				<br>
				<button class="btn btn-success btn-lg btn-block" onclick="changement_pays()">Modifier</button>
			</div>
		</div>
		<br>
		<div class="row" id="ensemble">
			<div class="col-sm-10" style="background-color:#aaa;">
				<h2>Téléphone</h2>
				<p id="old_phone">+33 1 23 45 67 89</p>
			</div>
			<div class="col-sm-2">
				<br>
				<button class="btn btn-success btn-lg btn-block" onclick="changement_phone()">Modifier</button>
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