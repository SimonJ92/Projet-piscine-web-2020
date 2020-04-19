<?php 
    //En tête
    session_start();

    //identifier le nom de base de données 
    $database = "ebay_ece"; 

    //connectez-vous dans votre BDD 
    //Rappel : votre serveur = localhost | votre login = root | votre mot de pass = '' (rien) 
    $db_handle = mysqli_connect('localhost', 'root', '' ); 
    $db_found = mysqli_select_db($db_handle, $database);

    $typeConnected=(isset($_SESSION['typeConnected']))?(int) $_SESSION['typeConnected']:1;
    //visiteur : 1
    //client : 2
    //vendeur : 3
    $idConnected=(isset($_SESSION['idConnected']))?(int) $_SESSION['idConnected']:0;
    //id si client connecté
    $pseudoConnected=(isset($_SESSION['pseudoConnected']))?$_SESSION['pseudoConnected']:'';
    //pseudo si vendeur connecté
    $boolAdmin=(isset($_SESSION['boolAdmin']))?$_SESSION['boolAdmin']:0;

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

    //Special vendeurs - admins
    if(isset($_POST["lienAdmin"])){
    	if ($_POST["lienAdmin"]) {
    		header('Location: liste_vendeurs_admin.php');
    	}
    }

    //Page
	
	//identifier le nom de base de données 
	$Numero = "";
	$Noms = "";
	$Photos = "";
	$MethodeVentes = "";
	$PrixDirects = "";
	$Descriptions = "";
	$Categories = "";
	$compteur = 0;

	/*	Déplacé en haut de la page
    //connectez-vous dans votre BDD 
    //Rappel : votre serveur = localhost | votre login = root | votre mot de pass = '' (rien) 
    $db_handle = mysqli_connect('localhost', 'root', '' ); 
    $db_found = mysqli_select_db($db_handle, $database);*/

    //si le BDD existe, faire le traitement 
    if ($db_found) { 
        $sql = "SELECT * FROM produit WHERE PseudoVendeur LIKE 'Simon'";
        $result = mysqli_query($db_handle, $sql); 
        while ($data = mysqli_fetch_assoc($result)) {
			$Numero .= $data['Numero'];
			$Numero .= "%marrq%";
			
			$Noms .= $data['Nom'];
			$Noms .= "%marrq%";
			
			$Photos .= $data['Photo1'];
			$Photos .= "%marrq%";
			
			$MethodeVentes .= $data['MethodeVente'];
			$MethodeVentes .= "%marrq%";
			
			$PrixDirects .= $data['PrixDirect'];
			$PrixDirects .= "%marrq%";
			
			$Descriptions .= $data['DescriptionLongue1'];
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
	
	
	/*if (isset($_POST["boutonAjout"])) {
		if($_POST["boutonAjout"] && $db_found) {ajoutNom ajoutDescription ajoutImage ajoutCategorie ajoutPrix
			$ajoutNom = isset($_POST["ajoutNom"])?$_POST["ajoutNom"]:"";
			$ajoutDescription = isset($_POST["ajoutDescription"])?$_POST["ajoutDescription"]:"";
			$ajoutImage = isset($_POST["ajoutImage"])?$_POST["ajoutImage"]:"";
			$ajoutCategorie = isset($_POST["ajoutCategorie"])?$_POST["ajoutCategorie"]:"";
			$ajoutPrix = isset($_POST["ajoutPrix"])?$_POST["ajoutPrix"]:"";
			$pseudoVendeur = isset($_POST["$pseudoConnected"])?$_POST["$pseudoConnected"]:"";
			if ($ajoutNom=="" || $ajoutDescription=="" || $ajoutImage=="" || $ajoutCategorie=="" || $ajoutPrix=="") {
			$erreurAjout = "Tous les champs doivent être remplis";
			}else{
				$sqlTestAjout = "SELECT * FROM produit where Nom like '%$ajoutNom%'";
				$resultTestAjout = mysqli_query($db_handle,$sqlTestAjout) or die (mysqli_error($db_handle));
				if(mysqli_num_rows($resultTestAjout) != 0){
					$erreurAjout = "Le produit existe déjà";
				}else{
					$sqlAjout = "insert into vendeur (nom, image, prix, description, categorie) values('$ajoutNom','$ajoutImage', '$ajoutPrix','$ajoutDescription','$ajoutCategorie')";
					$resultatAjout = mysqli_query($db_handle,$sqlAjout);
					$erreurAjout = "Ajouté";
				}
			}
		}
	}*/
	
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
						<div class="col-12 text-center">
								<?php 
                                	echo '<input type="'.(($typeConnected == 1)?"hidden":"submit").'" name="boutonCompte" value="Mon compte" class="btn btn-default" style="font-size: 1.5em;display:inline-block; margin-right: 10px;">';
                                 ?>
                                <?php 
                                	echo '<input type="submit" name="toggleConnexion" value="'.(($typeConnected == 1)?"Connexion":"Déconnexion").'" class="btn btn-danger" style="border: 1.5px solid black;display:inline-block;">';
                                 ?>
						</div>
							<?php 
								echo (($boolAdmin)?'<input type="submit" name="lienAdmin" value="Admin" class="col-12 btn btn-warning btn-lg" style="border: 1.5px solid black;margin-top: 20px;" align="center">':"");
							?>
					</form>
				</div>
			</div>
		</nav>

		<div class="navbar sticky-top" role="sub" >
			<?php echo '<a href="'.(($typeConnected == 3)?"accueil_vendeur.php":"accueil_client.php").'">Accueil</a>'; ?>
			<a href="page_mes_produits.php">Mes Produits</a>
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
				<button class="subnavbtn">Ventes<i class="fa fa-caret-down"></i></button>
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
			<input type="text" name="ajoutNom" id="nom">

			<label for="description"><b>Description</b></label>
			<input type="text" name="ajoutDescription" id="description"> 
			
			<label for="image"><b>Image</b></label>
			<input type="text" name="ajoutImage" id="image">
			
			<label for="categorie"><b>categorie</b></label>
			<input type="text" name="ajoutCategorie" id="categorie">
			
			<label for="categorie"><b>prix d'achat direct</b></label>
			<input type="text" name="ajoutPrix" id="prix">

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
		
		<script> 
			
			var Numero = "<?php echo $Numero ?>";
			var Noms = "<?php echo $Noms ?>";
			var Photos = "<?php echo $Photos ?>";
			var MethodeVentes = "<?php echo $MethodeVentes ?>";
			var PrixDirects = "<?php echo $PrixDirects ?>";
			var Descriptions = "<?php echo $Descriptions ?>";
			var Categories = "<?php echo $Categories ?>";
			var nbProduit = "<?php echo $compteur ?>";
			
			var n = 0;
			
			var compteur = 0;
			if("" == Noms && "" == Photos && "" == MethodeVentes && "" == PrixDirects && "" == Descriptions && "" == Categories)
			{
				var objet = document.createElement("div");
				objet.id = "objet";
				objet.className = "objet";
				document.getElementById("galerie_mes_produit").appendChild(objet);
				
				var h3 = document.createElement("h3");
				h3.textContent = "vous n'avez pas de produit en vente actuelement";
				document.getElementById("objet").appendChild(h3);
			}
			else
			{
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
					
					var h4_1 = document.createElement("h4"); 
					n = Noms.search("%marrq%");
					var Nom_objet = Noms.slice(0, n);
					h4_1.textContent = Nom_objet;
					Noms = Noms.replace(Nom_objet + "%marrq%", "");
					document.getElementById("td_2" + compteur).appendChild(h4_1);		

					var description = document.createElement("div"); 
					description.id = "description" + compteur; 
					description.className = "description_objet";
					document.getElementById("td_2" + compteur).appendChild(description);
					
					var p_1 = document.createElement("p"); 
					n = Descriptions.search("%marrq%");
					var Description_objet = Descriptions.slice(0, n);
					p_1.textContent = Description_objet;
					Descriptions = Descriptions.replace(Description_objet + "%marrq%", "");
					document.getElementById("description" + compteur).appendChild(p_1);
					
					var p_2 = document.createElement("p"); 
					n = Categories.search("%marrq%");
					var Categories_objet = Categories.slice(0, n);
					p_2.textContent = "Categorie : " + Categories_objet;
					Categories = Categories.replace(Categories_objet + "%marrq%", "");
					document.getElementById("td_2" + compteur).appendChild(p_2);
					
					var td_3 = document.createElement("td"); 
					td_3.id = "td_3" + compteur; 
					document.getElementById("tr" + compteur).appendChild(td_3);
					
					
					
					var h4_2 = document.createElement("h4"); 
					n = PrixDirects.search("%marrq%");
					var PrixDirects_objet = PrixDirects.slice(0, n);
					h4_2.textContent = PrixDirects_objet + " €";
					PrixDirects = PrixDirects.replace(PrixDirects_objet + "%marrq%", "");
					document.getElementById("td_3" + compteur).appendChild(h4_2);
					
					var h5 = document.createElement("h5"); 
					h5.textContent = "methode de vente:"; 
					document.getElementById("td_3" + compteur).appendChild(h5);
					
					var p_3 = document.createElement("p"); 
					n = MethodeVentes.search("%marrq%");
					var MethodeVentes_objet = MethodeVentes.slice(0, n);
					MethodeVentes = MethodeVentes.replace(MethodeVentes_objet + "%marrq%", "");
					
					
					var input_2 = document.createElement("input"); 
					input_2.id = "achat_par_methode" + compteur; 
					input_2.type="button";
					input_2.className = "button_achat";
					
					
					if("Encheres" == MethodeVentes_objet)
					{
						n = Numero.search("%marrq%");
						var Numero_objet = Numero.slice(0, n);
						Numero = Numero.replace(Numero_objet + "%marrq%", "");
						
						input_2.value = "etat actuel des encheres";
						input_2.href = "enchere_vendeur.php?numeroProduit=" + Numero_objet;
					}
					else
					{
						input_2.value = "etat actuel des negociations";
						input_2.href = "negoce_vendeur.php?numeroProduit=" + Numero_objet;
					}
					document.getElementById("td_3" + compteur).appendChild(input_2);
				}
			}
		</script>
	</body>
	
	
</html>
