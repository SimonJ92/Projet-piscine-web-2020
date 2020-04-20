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
    $categorieProduit = isset($_GET['categorieProduit'])?$_GET['categorieProduit']:0; 
    //0 - erreur
    //1 - Ferraille et trésors
    //2 - Bon pour le musée
    //3 - Accesoires VIP
	
	
	$rechercheNom = "";
	$rechercheVendeur = "";
	$maxPrix = "";
	$minPrix = "";
	
	if (isset($_POST["boutonRecherche"])) {
		if($_POST["boutonRecherche"] && $db_found){
			$rechercheNom = isset($_POST["rechercheNom"])?$_POST["rechercheNom"]:"";
		}
	} 
	if (isset($_POST["boutonRecherche"])) {
		if($_POST["boutonRecherche"] && $db_found){
			$rechercheVendeur = isset($_POST["rechercheVendeur"])?$_POST["rechercheVendeur"]:"";
		}
	} 

	if (isset($_POST["boutonRecherche"])) {
		if($_POST["boutonRecherche"] && $db_found){
			$maxPrix = isset($_POST["maxPrix"])?$_POST["maxPrix"]:"";
		}
	}
	if (isset($_POST["boutonRecherche"])) {
		if($_POST["boutonRecherche"] && $db_found){
			$minPrix = isset($_POST["minPrix"])?$_POST["minPrix"]:"";
		}
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
	
		<div class="page">
			<h1> Catalogue :  <?php echo (($categorieProduit == 1)?"Ferraille et trésors":(($categorieProduit == 2)?"Bon pour le musée":"Accessoires VIP")); ?> </h1>
			
			
			<div class="titre">
				
			</div>
			<div class="row">
				<div class="col-1">
					<div class="row">
						<div class="col-12 container" id="recherche">
							<form action="" method="post" id="formRecherche" class="form-inline">
								<div style="margin: 0px auto;">
									<h4> Rechercher :</h4> 
									<input type="text" name="rechercheNom" class="form-control" placeholder="un produit par son nom" id="barreRecherche">
									<input type="text" name="rechercheVendeur" class="form-control" placeholder="les produits d'un vendeur" id="barreRecherche">
									<h5 style="text-align: center;"> ne garder que les objet entre </h5>
									<p><input name="minPrix" style="width: 50px;" type="int" id="prix_min"> € et <input name="maxPrix" style="width: 50px;" type="int" id="prix_max">€ </p>
									<input type="submit" name="boutonRecherche" id="boutonRecherche" class="btn btn-default" value="Rechercher">
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="col-10">
					<div id="galerie">
						<?php 
							if ($db_found) 
							{
								$sql = "Select * from produit ";
								if($categorieProduit == 0){
									$sql .= "where 0";
								}elseif($categorieProduit == 1) {
									$sql .= "where Categorie like 'Ferraille'";
								}elseif($categorieProduit == 2) {
									$sql .= "where Categorie like 'Musee'";
								}elseif ($categorieProduit == 3) {
									$sql .= "where Categorie like 'VIP'";
								}
								if($rechercheNom != ""){
									$sql .= " AND Nom like '%$rechercheNom%'";
								}
								if($rechercheVendeur != ""){
									$sql .= " AND PseudoVendeur like '%$rechercheVendeur%'";
								}
								if(($maxPrix != "") &&($minPrix != ""))
								{
									$sql .= " AND (PrixDirect < '$maxPrix' AND (NOT PrixDirect < '$minPrix'))";
								}
								else if($maxPrix != ""){
									$sql .= " AND PrixDirect < '$maxPrix'";
								}
								else if($minPrix != ""){
									$sql .= " AND PrixDirect > '$minPrix'";
								}
								
								$result = mysqli_query($db_handle, $sql) or die (mysqli_error($db_handle));
								if (mysqli_num_rows($result) == 0) {
									echo "Aucun produit enregistré";
								}
								else
								{
									while ($data= mysqli_fetch_assoc($result)) {
										echo '
										<div class="objet">
											<table>
												<tr>
													<td> 
														<img class="image" src="'.$data["Photo1"].'">
													</td>
													<td> 
														<h4>'.$data["Nom"].'</h4>
														<div class="description_objet">
															<p>'.$data["DescriptionLongue1"].'</p>
															<p>'.$data["PseudoVendeur"].'</p>
														</div>
													</td>
													<td> 
														<h5>Acheter: </h5>
														<h4>'.$data["PrixDirect"].'</h4>
														<p>'.$data["PseudoVendeur"].'</p>
														<p>'.$data["MethodeVente"].'</p>
														<a href="produit_client.php?numeroProduit='.$data["Numero"].'"> aller a la page du produit </a>
													</td>
												</tr>
											</table>
										</div>
										';
									}
								}
							}
							else
							{
								echo "Database not found";
							}
						 ?>
					</div>
				</div>
				<div class="col-1"></div>
			</div>
			
		</div>
		<div class="col-1"></div>
	
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



