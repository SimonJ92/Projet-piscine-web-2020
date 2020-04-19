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


	//Page
    $categorieProduit = isset($_GET['categorieProduit'])?$_GET['categorieProduit']:0; 
    //0 - erreur
    //1 - Ferraille et trésors
    //2 - Bon pour le musée
    //3 - Accesoires VIP
	
	$Numero = "";
	$Noms = "";
	$Photos = "";
	$MethodeVentes = "";
	$PrixDirects = "";
	$Descriptions = "";
	$Vendeur = "";
	$compteur = 0;
	
	$chercheNom = "";
	$chercheVendeur = "";
	$maxPrix = "";
	$minPrix = "";
	
	if ($db_found) { 
		$sql = "SELECT * FROM produit WHERE Categorie LIKE '$categorieProduit'";
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
			
			$Vendeur .= $data['PseudoVendeur'];
			$Vendeur .= "%marrq%";
			
			$compteur = $compteur + 1;
        }   
    }   
    else  
	{
        echo "Database not found"; 
	} 
    

 ?>

<!DOCTYPE html>
<html>
	<head>
		<title>Catalogue</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" href="Images/favicon.ico" type="images/x-icon">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<link rel="stylesheet" href="Styles/style_catalogue.css">
		<link rel="stylesheet" href="Styles/MyFooter.css">
		<link rel="stylesheet" href="Styles/nav_bar.css">
		<link rel="stylesheet" href="Styles/style.css">
		<link rel="stylesheet" href="Styles/bootstrap.min.css">
		
		 <script>
			//fonction qui cache ou affiche l'option de trie pas date de fin d'enchere
			//si le cliant choisie de ne regarder que les meilleur offre
			function masque_trie_enchere()
			{
				if("meilleur offre" == document.getElementById("type_vente").value)
				{
					
					$("#trie_encheres").hide();
				}
				else
				{
					$("#trie_encheres").show();
				}
			}
			 
			$(document).ready(function(){
				$("#valider").click(function(){
					masque_trie_enchere();
					var nom_objet = document.getElementById("nom_objet").value
					var nom_vendeur = document.getElementById("nom_vendeur").value
					var prix_min = document.getElementById("prix_min").value
					var prix_max = document.getElementById("prix_max").value
					var type_vente = document.getElementById("type_vente").value
					var type_trie = document.getElementById("type_trie").value

					//blindage
					if(prix_min > prix_max)
					{
						var sauve = prix_min;
						prix_min = prix_max;
						prix_max = sauve;
					}

				});
			}); 
		 </script> 
	</head>

	<body>
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
                        <div class="col-12 text-right">
                                <?php 
                                	echo '<input type="'.(($typeConnected == 1)?"hidden":"submit").'" name="boutonCompte" value="Mon compte" class="btn btn-default" style="font-size: 1.5em;display:inline-block; margin-right: 10px;">';
                                 ?>
                                <?php 
                                	echo '<input type="submit" name="toggleConnexion" value="'.(($typeConnected == 1)?"Connexion":"Déconnexion").'" class="btn btn-danger" style="border: 1.5px solid black;display:inline-block;">';
                                 ?>
                        </div>
                        <div class="col-12 text-center">
                            <?php echo ($typeConnected == 1)?"":
                                '<a class="nav-link" href="panier.php">
                                    <img style="max-width:100px;" src="Images/paniers.png">
                                </a>';
                             ?>
                        </div>
                    </form>
                </div>

            </div>
        </nav>

        <div class="navbar sticky-top" role="sub" >
            <?php echo '<a href="'.(($typeConnected == 3)?"accueil_vendeur.php":"accueil_client.php").'">Accueil</a>'; ?>
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
                <button class="subnavbtn">Achats<i class="fa fa-caret-down"></i></button>
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
	
		<div class="page">
			<form>
				<table>
					<tr>
						<td>
							<div class="recherche">
								<div class="filtre">
									<p> filtrer par par type de vente proposée </p>
									<p> <select id="type_vente" size=1>
											<option id="options_type_vente">toute</option>
											<option id="options_type_vente">meilleur offre</option>
											<option id="options_type_vente">vente aux encheres</option>
										</select> </p>
								</div>
								<div class="filtre">
									<p> trier par </p>
									<p> <select id="type_trie" size=1>
											<option>ordre alphabetique</option>
											<option>prix d'achat direct croissant</option>
											<option>prix d'achat direct decroissant</option>
											<option id="trie_encheres">date de fin d'encheres</option>
										</select> </p>
								</div>
								<input type="button" id="valider" value="valider la recherche">
								
								
								<form action="page_mes_produits.php" method="post" class="info_form" >
									<h3> Filtre </h3>
									
									<div class="filtre">
										<p> chercher un objet par son nom :</p> 
										<p> <input type="text" name="chercheNom" id="nom"> </p> 
									</div>
									<div class="filtre">
										<p> chercher un objet par son vendeur : </p>
										<p> <input type="text" name="chercheVendeur" id="nom"> </p>
									</div>
									<div class="filtre">
										<p> ne garder que les objet entre </p>
										<p><input name="maxPrix" style="width: 50px;" type="int" id="prix_min"> € et <input name="minPrix" style="width: 50px;" type="int" id="prix_max">€ </p>
									</div>
																	
									<input type="submit" name="boutonAjout" id="btn_ajout" class="btn" value="Ajouter">
								</form>
							</div>
						</td>
						<td>
							<div class="titre">
								<h1> Catalogue :  <?php echo $categorieProduit ?> </h1>
							</div>
							<div id="galerie">	</div>
						</td>
					</tr>						
				</table>
			</form>
		
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
			//////////////////////////////////////////////////////////
			//ajout automatique des produits depui la base de donnee//
			//////////////////////////////////////////////////////////
			
			var Numero = "<?php echo $Numero ?>";
			var Noms = "<?php echo $Noms ?>";
			var Photos = "<?php echo $Photos ?>";
			var MethodeVentes = "<?php echo $MethodeVentes ?>";
			var PrixDirects = "<?php echo $PrixDirects ?>";
			var Descriptions = "<?php echo $Descriptions ?>";
			var Vendeur = "<?php echo $Vendeur ?>";
			var nbProduit = "<?php echo $compteur ?>";
			
			var n = 0;
			var compteur = 0;
			
			if("" == Noms && "" == Photos && "" == MethodeVentes && "" == PrixDirects && "" == Descriptions && "" == Vendeur)
			{
				var objet = document.createElement("div");
				objet.id = "objet";
				objet.className = "objet";
				document.getElementById("galerie_mes_produit").appendChild(objet);
				
				var h3 = document.createElement("h3");
				h3.textContent = "il n'y a pas d'objet de cette categorie";
				document.getElementById("objet").appendChild(h3);
			}
			else
			{
				for(compteur = 0; compteur < nbProduit; ++compteur)
				{
					var objet = document.createElement("div");
					objet.id = "objet" + compteur;
					objet.className = "objet";
					document.getElementById("galerie").appendChild(objet);
					
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
					n = Vendeur.search("%marrq%");
					var Categories_objet = Vendeur.slice(0, n);
					p_2.textContent = "objet mit en vente par : " + Categories_objet;
					Vendeur = Vendeur.replace(Categories_objet + "%marrq%", "");
					document.getElementById("td_2" + compteur).appendChild(p_2);
					
					var td_3 = document.createElement("td"); 
					td_3.id = "td_3" + compteur; 
					document.getElementById("tr" + compteur).appendChild(td_3);
					
					var h5_1 = document.createElement("h5"); 
					h5_1.textContent = "Acheter:"; 
					document.getElementById("td_3" + compteur).appendChild(h5_1);
					
					var h4_2 = document.createElement("h4"); 
					n = PrixDirects.search("%marrq%");
					var PrixDirects_objet = PrixDirects.slice(0, n);
					h4_2.textContent = PrixDirects_objet + " €";
					PrixDirects = PrixDirects.replace(PrixDirects_objet + "%marrq%", "");
					document.getElementById("td_3" + compteur).appendChild(h4_2);
					
					var p_3 = document.createElement("p"); 
					n = MethodeVentes.search("%marrq%");
					var MethodeVentes_objet = MethodeVentes.slice(0, n);
					MethodeVentes = MethodeVentes.replace(MethodeVentes_objet + "%marrq%", "");
					if("Encheres" == MethodeVentes_objet)
					{
						p_3.textContent = "aussi disponible en ventes aux encheres";
					}
					else
					{
						p_3.textContent = "le prix peut etre negocier avec le vendeur";
					}
					document.getElementById("td_3" + compteur).appendChild(p_3);
					
					
					n = Numero.search("%marrq%");
					var Numero_objet = Numero.slice(0, n);
					Numero = Numero.replace(Numero_objet + "%marrq%", "");
					
					
					
					var href = document.createElement("a"); 
					href.textContent = "aller a la page du produit";
					href.href = "produit_client.php?numeroProduit=" + Numero_objet;
					document.getElementById("td_3" + compteur).appendChild(href);								
				}
			}
		</script>
	</body>	
</html>
