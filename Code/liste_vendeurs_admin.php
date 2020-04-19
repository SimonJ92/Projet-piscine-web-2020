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
	$erreurAjout = "";
	$filtreRecherche = "";
		
	if (isset($_POST["boutonRecherche"])) {
		if($_POST["boutonRecherche"] && $db_found){
			$rechercheNom = isset($_POST["rechercheNom"])?$_POST["rechercheNom"]:"";
			$filtreRecherche .= $rechercheNom;
		}
	}
	if (isset($_POST["boutonAjout"])) {
		if($_POST["boutonAjout"] && $db_found) {
			$ajoutNom = isset($_POST["ajoutNom"])?$_POST["ajoutNom"]:"";
			$ajoutPseudo = isset($_POST["ajoutPseudo"])?$_POST["ajoutPseudo"]:"";
			$ajoutMail = isset($_POST["ajoutMail"])?$_POST["ajoutMail"]:"";
			$ajoutCheckAdmin = isset($_POST["ajoutCheckAdmin"])?$_POST["ajoutCheckAdmin"]:"";
			if ($ajoutNom=="" || $ajoutPseudo=="" || $ajoutMail=="") {
			$erreurAjout = "Tous les champs doivent être remplis";
			}else{
				$sqlTestAjout = "SELECT * FROM vendeur where Pseudo like '%$ajoutPseudo%'";
				$resultTestAjout = mysqli_query($db_handle,$sqlTestAjout) or die (mysqli_error($db_handle));
				if(mysqli_num_rows($resultTestAjout) != 0){
					$erreurAjout = "Le vendeur existe déjà";
				}else{
					$sqlAjout = "INSERT into vendeur (pseudo,AdresseMail,Nom,Admin) values('$ajoutPseudo','$ajoutMail','$ajoutNom','$ajoutCheckAdmin')";
					$resultatAjout = mysqli_query($db_handle,$sqlAjout);
					$erreurAjout = "Ajouté";
				}
			}
		}
	}
	if(isset($_POST["supprimerUser"])){
		if($_POST["supprimerUser"] && $db_found){
			$supprimerPseudo = isset($_POST["supprimerPseudo"])?$_POST["supprimerPseudo"]:"";
			if($supprimerPseudo == ""){
				echo "le pseudo n'a pas été transmis";
			}else{
				$sqlSupprimer = "DELETE from vendeur where Pseudo like '%$supprimerPseudo%'";
				$resultDelete = mysqli_query($db_handle,$sqlSupprimer) or die (mysqli_error($db_handle));
			}
		}
	}
 ?>


<!DOCTYPE html>
<html>
	<head>
		<title>Admnistration des vendeurs</title>
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
		<link rel="stylesheet" type="text/css" href="Styles/liste-vendeurs.css">
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

	
		<div class="container-fluid">
			<div class="row">
				<div class="container-fluid" id="wrapperInterieur">
					<div class="row text-center" id="titreWrapper">
						<h1 class="col-12"><strong>Liste des vendeurs enregistrés</strong></h1>
					</div>
					<div class="row">
						<div class="col-12 container" id="recherche">
							<form action="" method="post" id="formRecherche" class="form-inline">
								<div style="margin: 0px auto;">
									<input type="text" name="rechercheNom" class="form-control" placeholder="Rechercher un pseudo" id="barreRecherche">
									<input type="submit" name="boutonRecherche" id="boutonRecherche" class="btn btn-default" value="Rechercher">
								</div>
							</form>
						</div>
					</div>
					
					<div class="row">
						<div class="col-1"></div>
						<div class="col-10">
							<div class="container-fluid" id="listeVendeurs">

								<?php 
									if ($db_found) {
										$sqlVendeurs = "Select * from vendeur";
										if($filtreRecherche != ""){
											$sqlVendeurs .= " where Pseudo like '%$filtreRecherche%'";
										}
										$resultVendeurs = mysqli_query($db_handle, $sqlVendeurs);
										if (mysqli_num_rows($resultVendeurs) == 0) {
											echo "Aucun vendeur enregistré";
										}else{
											while ($dataVendeurs = mysqli_fetch_assoc($resultVendeurs)) {
												echo '
												<div class="vendeur">
													<span id="nomVendeur">'.$dataVendeurs["Nom"].'</span>
													<span id="pseudoVendeur">'.$dataVendeurs["Pseudo"].'</span>
													<span id="mailVendeur">'.$dataVendeurs["AdresseMail"].'</span>
													<div class="checkbox">
														<label id="adminUser"><input type="checkbox" name="adminUser" id="checkAdmin" '.($dataVendeurs["Admin"]?"checked":"unchecked").' disabled>Admin</label>
													</div>
													<form id="formSupprimer" class="form-inline" action="liste_vendeurs_admin.php" method="post">
														<input type="hidden" name="supprimerPseudo" value="'.$dataVendeurs["Pseudo"].'">
														<input id="supprimerUser" type="submit" class="btn btn-danger" name="supprimerUser" value="Supprimer">
													</form>
												</div>
												';
											}
										}
									}else{
										echo "Database not found";
									}
								 ?>

							</div>
						</div>
						<div class="col-1"></div>
					</div>
					<div class="row">
						<div class="col-md-1 col-sm-12"></div>
						<div class="col-md-10 col-sm-12 container" id="ligneAjout">
							<h3>Ajouter un vendeur </h3>
							<form action="liste_vendeurs_admin.php" method="post" id="formAjout" class="form-inline">
								<input type="text" name="ajoutNom" class="form-control" placeholder="Nom" id="fieldAjout">
								<input type="text" name="ajoutPseudo" class="form-control" placeholder="Pseudo" id="fieldAjout">
								<input type="email" name="ajoutMail" class="form-control" placeholder="E-mail" id="fieldAjout">
								<div class="checkbox">
	      							<label id="labelCheckAdmin"><input type="checkbox" name="ajouCheckAdmin" id="ajoutCheckAdmin" value="1">Admin</label>
	    						</div>				
								<input type="submit" name="boutonAjout" id="boutonAjout" class="btn btn-default" value="Ajouter">
								<?php echo "   $erreurAjout"; ?>
							</form>
						</div>
						<div class="col-md-1 col-sm-12"></div>
					</div>
				</div>
			</div>
		</div>
	
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