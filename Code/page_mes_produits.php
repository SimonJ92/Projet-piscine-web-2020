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
	$Noms = "";
	$Photos = "";
	$MethodeVentes = "";
	$PrixDirects = "";
	$Descriptions = "";
	$Categories = "";
	$compteur = 0;

    //connectez-vous dans votre BDD 
    //Rappel : votre serveur = localhost | votre login = root | votre mot de pass = '' (rien) 
    $db_handle = mysqli_connect('localhost', 'root', '' ); 
    $db_found = mysqli_select_db($db_handle, $database); 

    //si le BDD existe, faire le traitement 
    if ($db_found) { 
        $sql = "SELECT * FROM produit";
        $result = mysqli_query($db_handle, $sql); 
        while ($data = mysqli_fetch_assoc($result)) {
			$Noms .= $data['Nom'];
			$Noms .= "%marrq%";
			
			$Photos .= $data['Photo1'];
			$Photos .= "%marrq%";
			
			$MethodeVentes .= $data['MethodeVente'];
			$MethodeVentes .= "%marrq%";
			
			$PrixDirects .= $data['PrixDirect'];
			$PrixDirects .= "%marrq%";
			
			$Descriptions .= $data['DescriptionCourte'];
			$Descriptions .= "%marrq%";
			
			$Categories .= $data['Categorie'];
			$Categories .= "%marrq%";
			
			$compteur = $compteur + 1;
        }   //end while 
    }   //end if 
    else  //si le BDD n'existe pas 
	{
        echo "Database not found"; 
	}  
    //fermer la connection 
    mysqli_close($db_handle);
	
	//echo $Photos;
	
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
		
		
		<div  id="galerie_mes_produit">	</div>
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
			
			var Noms = "<?php echo $Noms ?>";
			var Photos = "<?php echo $Photos ?>";
			var MethodeVentes = "<?php echo $MethodeVentes ?>";
			var PrixDirects = "<?php echo $PrixDirects ?>";
			//var Descriptions = "<?php echo $Descriptions ?>";
			var Categories = "<?php echo $Categories ?>";
			var nbProduit = "<?php echo $compteur ?>";
			
			var n = 0;
			
			var compteur = 0;
			
			for(compteur = 0; compteur < nbProduit; ++compteur)
			{
				var objet = document.createElement("div");
				objet.id = "objet" + compteur;
				objet.className = "objet";
				document.getElementById("galerie_mes_produit").appendChild(objet);
				
				var form = document.createElement("form"); 
				form.id = "form" + compteur; 
				document.getElementById("objet" + compteur).appendChild(form);
				
				var table = document.createElement("table"); 
				table.id = "table" + compteur; 
				document.getElementById("form" + compteur).appendChild(table);
				
				var tr = document.createElement("tr"); 
				tr.id = "tr" + compteur; 
				document.getElementById("table" + compteur).appendChild(tr);
				
				var td_1 = document.createElement("td"); 
				td_1.id = "td_1" + compteur; 
				document.getElementById("tr" + compteur).appendChild(td_1);
				
				var img = document.createElement("img"); 
				
				img.className = "image";
				n = Photos.search("%marrq%");
				var adresseImage = Photos.slice(0, n);
				img.src = adresseImage;
				Photos = Photos.replace(adresseImage + "%marrq%", "");
				document.getElementById("td_1" + compteur).appendChild(img);
				
				var td_2 = document.createElement("td"); 
				td_2.id = "td_2" + compteur; 
				document.getElementById("tr" + compteur).appendChild(td_2);
				
				var h4 = document.createElement("h4"); 
				n = Noms.search("%marrq%");
				var Nom_objet = Noms.slice(0, n);
				h4.textContent = Nom_objet;
				Noms = Noms.replace(Nom_objet + "%marrq%", "");
				document.getElementById("td_2" + compteur).appendChild(h4);		

				var description = document.createElement("div"); 
				description.id = "description" + compteur; 
				description.className = "description_objet";
				document.getElementById("td_2" + compteur).appendChild(description);
				
				/*var p_1 = document.createElement("p"); 
				n = Descriptions.search("%marrq%");
				var Description_objet = Descriptions.slice(0, n);
				p_1.textContent = Description_objet;
				Descriptions = Descriptions.replace(Description_objet + "%marrq%", "");
				document.getElementById("description" + compteur).appendChild(p_1);*/
				
				var p_2 = document.createElement("p"); 
				n = Categories.search("%marrq%");
				var Categories_objet = Categories.slice(0, n);
				p_2.textContent = "Categorie:" + Categories_objet;
				Categories = Categories.replace(Categories_objet + "%marrq%", "");
				document.getElementById("td_2" + compteur).appendChild(p_2);
				
				var td_3 = document.createElement("td"); 
				td_3.id = "td_3" + compteur; 
				document.getElementById("tr" + compteur).appendChild(td_3);
				
				var h5_1 = document.createElement("h5"); 
				h5_1.textContent = "methode de vente:"; 
				document.getElementById("td_3" + compteur).appendChild(h5_1);
				
				var h5_2 = document.createElement("h5"); 
				n = PrixDirects.search("%marrq%");
				var PrixDirects_objet = PrixDirects.slice(0, n);
				p_2.textContent = PrixDirects_objet + " €";
				PrixDirects = PrixDirects.replace(PrixDirects_objet + "%marrq%", "");
				document.getElementById("td_3" + compteur).appendChild(h5_2);
				
				var input = document.createElement("input"); 
				input.id = "achat_imediat" + compteur; 
				input.className = "achat_imediat";
				input.type="button";
				input.value="acheter maintenant";
				document.getElementById("td_3" + compteur).appendChild(input);
				
				var h5_3 = document.createElement("h5"); 
				h5_3.textContent = "OU"; 
				document.getElementById("td_3" + compteur).appendChild(h5_3);
				
				var p_3 = document.createElement("p"); 
				n = MethodeVentes.search("%marrq%");
				var MethodeVentes_objet = MethodeVentes.slice(0, n);
				MethodeVentes = MethodeVentes.replace(MethodeVentes_objet + "%marrq%", "");
				
				
				if("Encheres" == MethodeVentes_objet)
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
				document.getElementById("td_3" + compteur).appendChild(p_3);
			}
		</script>
	</body>
	
	
</html>
