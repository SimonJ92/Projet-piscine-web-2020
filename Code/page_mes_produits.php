<?php 
    //En tête
    session_start();

    $db_handle = mysqli_connect('localhost', 'root', ''); 
    $db_found = mysqli_select_db($db_handle, "ebay-ece");

    $typeConnected=(isset($_SESSION['typeConnected']))?(int) $_SESSION['typeConnected']:1;
    //visiteur : 1
    //client : 2
    //vendeur : 3
    $idConnected=(isset($_SESSION['idConnected']))?(int) $_SESSION['idConnected']:0;
    //id si client connecté
    $pseudoConnected=(isset($_SESSION['pseudoConnected']))?$_SESSION['pseudoConnected']:'';
    //pseudo si vendeur connecté	
	
	//identifier le nom de base de données 
    $database = "ebay-ece"; 
	$Noms = array();
	$Photos = array();
	$MethodeVentes = array();
	$PrixDirects = array();
	$Descriptions = array();
	$Categories = array();

    //connectez-vous dans votre BDD 
    //Rappel : votre serveur = localhost | votre login = root | votre mot de pass = '' (rien) 
    $db_handle = mysqli_connect('localhost', 'root', '' ); 
    $db_found = mysqli_select_db($db_handle, $database); 

    //si le BDD existe, faire le traitement 
    if ($db_found) { 
        $sql = "SELECT * FROM produit";
        $result = mysqli_query($db_handle, $sql); 
        while ($data = mysqli_fetch_assoc($result)) {
			array_push ($Noms, $data['Nom']);
			array_push ($Photos, $data['Photo1']);
			array_push ($MethodeVentes, $data['MethodeVente']);
			array_push ($PrixDirects, $data['PrixDirect']);
			array_push ($Descriptions, $data['DescriptionLongue1']);
			array_push ($Categories, $data['Categorie']);
        }   //end while 
    }   //end if 
    else  //si le BDD n'existe pas 
	{
        echo "Database not found"; 
	}  
    //fermer la connection 
    mysqli_close($db_handle); 
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Catalogue Ebay ECE</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<link rel="stylesheet" href="Styles/style_mes_produits.css">
		<link rel="stylesheet" href="Styles/MyFooter.css">
		<link rel="stylesheet" href="Styles/nav_bar.css">
		
		 <script>
			
			
		 
			function ouvre_form() {
				document.getElementById("info_produit").style.display = "block";
			}

			function ferme_form() {
				document.getElementById("info_produit").style.display = "none";
			} 
			
			$(document).ready(function(){
				$("#btn_ajout").click(function(){
					var titre_produit = document.getElementById("titre").value
					var description_produit = document.getElementById("description").value
					var image_produit = document.getElementById("image").value
					var categorie_produit = document.getElementById("categorie").value
					//alert(nom_produit + description_produit + image_produit + categorie_produit);
				});
			}); 
			
		 </script> 
	</head>

	<body>	
	<!-- 00 -->
	<!-- TOP -->
	<!-- 00 -->
		
		<nav class="navbar navbar-expand-md" role="main" >
			<a class="navbar-brand" href="#">
				<img src="Images/logo.png" alt="" style="max-width: 150px;">
			</a>
		 	<button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#main-navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse text-center" style="width: 100%;">
				<h1 style="margin: 0 auto;">Bienvenue sur Ebay-ECE</h1>
			</div>
			<div class="collapse navbar-collapse" id="main-navigation" style="width: 150px;">
				<div class="row">
					<div class="col-12 text-right">
						<a class="nav-link" href="#">Mon Compte</a>
					</div>
					<div class="col-12 text-right">
						<a class="nav-link" href="#">
							<img style="max-width:100px;" src="Images/paniers.png" alt="">
						</a>
					</div>	
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
	
	<div class="page" align ="middle" >
		
		<div class="titre">
			<h1>Mes produits</h1>
		</div>
		
		
		<div  id="galerie_mes_produit">
			<div  id="objet" class = "objet">
				<form>
					<table>
						<tr>
							<td>
								<img class="image" src="Images/Images-produits/costume_original_Darth_Vador.png">
							</td>
							<td>
								<h4>
									<?php echo $Noms[4] ?>
								</h4>
								<div class="description_objet">
									<p> <?php echo $Descriptions[4] ?>  <p>
								</div>
								<p> Categorie: <?php echo $Categories[4] ?> </p>
							</td>
							<td>
								<h5> methode de vente: </h5>
								<h5><?php echo $PrixDirects[4] ?> € </h5>
								<input type="button" id="achat_imediat" value="acheter maintenant">
								<h5>ou </h5>
								<p href="#encheres" id="encheres"> participer aux encheres </p>
								<p href="#negociations" id="meilleur_offre"> debuter un negociation avec le vendeur </p>
							</td>
						</tr>						
					</table>
				</form>
			</div >			
		</div>
		<button id="ajoute_produit" onclick="ouvre_form()"> ajouter un produit a la vente </button>
		
		<div class="pop_up" id="info_produit" >
		  <form action="mes_produits.php" class="info_form" >
			<h1>ajouter un nouveau produit</h1>

			<label for="titre"><b>Titre</b></label>
			<input type="text" id="nom">

			<label for="description"><b>Description</b></label>
			<input type="text" id="description">
			
			<label for="image"><b>Image</b></label>
			<input type="text" id="image">
			
			<label for="categorie"><b>categorie</b></label>
			<input type="text" id="categorie">

			<button type="button" class="btn" id="btn_ajout">ajouter</button>
			<button type="button" class="btn fermer" onclick="ferme_form()">fermer</button>
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
		
		<script> 
			var compteur = 0;
			
			for(compteur = 0; compteur < 2; ++compteur)
			{
				var objet = document.createElement("div"); // Création d'un élément li
				objet.id = "objet" + compteur;//+ compteur; // Définition de son identifiant
				objet.className = "objet";
				document.getElementById("galerie_mes_produit").appendChild(objet);
				
				var form = document.createElement("form"); // Création d'un élément li
				form.id = "form" + compteur; // Définition de son identifiant
				document.getElementById("objet" + compteur).appendChild(form);
				
				var table = document.createElement("table"); // Création d'un élément li
				table.id = "table" + compteur; // Définition de son identifiant
				document.getElementById("form" + compteur).appendChild(table);
				
				var tr = document.createElement("tr"); // Création d'un élément li
				tr.id = "tr" + compteur; // Définition de son identifiant
				document.getElementById("table" + compteur).appendChild(tr);
				
				var td_1 = document.createElement("td"); // Création d'un élément li
				td_1.id = "td_1" + compteur; // Définition de son identifiant
				document.getElementById("tr" + compteur).appendChild(td_1);
				
				var img = document.createElement("img"); // Création d'un élément li
				img.className = "image";
				var str = "<?php echo $Photos[4] ?>".replace("4", "2");
				//str = str.replace("", compteur);
				img.src = str;
				alert(str);
				//alert(img.src);
				document.getElementById("td_1" + compteur).appendChild(img);
				
				/*var td_2 = document.createElement("td"); // Création d'un élément li
				td_2.id = "td_2" + compteur; // Définition de son identifiant
				document.getElementById("tr" + compteur).appendChild(td_2);
				
				var h4 = document.createElement("h4"); // Création d'un élément li
				h4.textContent = "<?php echo $Noms[" + compteur + "] ?>"; // Définition de son identifiant
				document.getElementById("td_2" + compteur).appendChild(h4);		

				var description = document.createElement("div"); // Création d'un élément li
				description.id = "description" + compteur; // Définition de son identifiant
				description.className = "description_objet";
				document.getElementById("td_2" + compteur).appendChild(description);
				
				var p_1 = document.createElement("p"); // Création d'un élément li
				p_1.textContent = "<?php echo $Descriptions[" + compteur + "] ?>";
				document.getElementById("description" + compteur).appendChild(p_1);
				
				var p_2 = document.createElement("p"); // Création d'un élément li
				p_2.textContent = "Categorie: <?php echo $Categories[" + compteur + "] ?>";
				document.getElementById("td_2" + compteur).appendChild(p_2);
				
				var td_3 = document.createElement("td"); // Création d'un élément li
				td_3.id = "td_3" + compteur; // Définition de son identifiant
				document.getElementById("tr" + compteur).appendChild(td_3);
				
				var h5_1 = document.createElement("h5"); // Création d'un élément li
				h5_1.textContent = "methode de vente:"; // Définition de son identifiant
				document.getElementById("td_3" + compteur).appendChild(h5_1);
				
				var h5_2 = document.createElement("h5"); // Création d'un élément li
				h5_2.textContent = "<?php echo $PrixDirects[" + compteur + "] ?> €"; // Définition de son identifiant
				document.getElementById("td_3" + compteur).appendChild(h5_2);
				
				var input = document.createElement("input"); // Création d'un élément li
				input.id = "achat_imediat" + compteur; // Définition de son identifiant
				input.className = "achat_imediat";
				input.type="button";
				input.value="acheter maintenant";
				document.getElementById("td_3" + compteur).appendChild(input);
				
				var h5_3 = document.createElement("h5"); // Création d'un élément li
				h5_3.textContent = "OU"; // Définition de son identifiant
				document.getElementById("td_3" + compteur).appendChild(h5_3);
				
				var p_3 = document.createElement("p"); // Création d'un élément li
				
				if("Encheres" == <?php echo $MethodeVentes[4] ?>)
				{
					p_3.textContent = "participer aux encheres";
					p_3.href = "#encheres";
				}
				else
				{
					p_3.textContent = "debuter un negociation avec le vendeur";
					p_3.href = "#negociations";
				}
				
				p_3.className = "lien_methode_vente";
				document.getElementById("td_3" + compteur).appendChild(p_3);*/
			}
		</script>
	</body>
	
	
</html>
 
<?php
	//fermer la connection 
    mysqli_close($db_handle); 
?>
