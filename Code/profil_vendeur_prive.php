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

    //prompt function (https://stackoverflow.com/questions/30388997/equivalent-of-alert-and-prompt-in-php)
    function prompt($prompt_msg){
        

        
        //return($answer);
    }


    //on récupère les infos du vendeur
    $dataInfosVendeur = "";
    if($db_found){
    	$sqlInfosVendeur = "SELECT * from vendeur where Pseudo like '%$pseudoConnected%'";
    	$resultatInfosVendeur = mysqli_query($db_handle,$sqlInfosVendeur) or die (mysqli_error($db_handle));
    	if(mysqli_num_rows($resultatInfosVendeur) == 0){
    		echo "Erreur : vendeur non trouvé";
    	}else{
    		$dataInfosVendeur = mysqli_fetch_assoc($resultatInfosVendeur);
    	}
    }

    $erreurTexte = "";
    if(isset($_POST["buttonSaveText"]) && $db_found){
    	if($_POST["buttonSaveText"]){
    		$newPseudo = isset($_POST["newPseudo"])?$_POST["newPseudo"]:"";
    		$newDescription = isset($_POST["newDescription"])?$_POST["newDescription"]:"";
    		if($newPseudo == ""){
    			$erreurTexte ="Erreur : le pseudo doit être rensigné";
    		}else{
    			//On vérifie que les infos ne contiennent pas de caractères spéciaux
    			$pattern= '/[\'^£$%&*()}{@#~?><>,|=_+¬-éàèùüïûç]/';
    			if(preg_match($pattern, $newPseudo) || preg_match($pattern, $newDescription)){
    				$erreurTexte = "Erreur : les champs ne doivent pas contenir de caractères spéciaux";

    				//TODO : plus de vérification des champs

    			}else{
    				if($pseudoConnected == $newPseudo){	//Pas de changement de pseudon juste de description
    					$sqlUpdateTexte = "UPDATE vendeur SET Description = '".$newDescription."' where Pseudo like '%$pseudoConnected%'";
    					$resultatUpdateTexte = mysqli_query($db_handle,$sqlUpdateTexte) or die (mysqli_error($db_handle));
    					header('Location: profil_vendeur_prive.php');
    				}else{
    					//On doit vérifier que le pseudo n'appartient pas déjà à quelqu'un
	    				$sqlVerifPseudo = "SELECT * from vendeur where Pseudo like '%$newPseudo%' and Pseudo not like '%$pseudoConnected%'";
	    				$resultatVerifPseudo = mysqli_query($db_handle,$sqlVerifPseudo);
	    				if(mysqli_num_rows($resultatVerifPseudo) != 0){
	    					$erreurTexte = "Erreur : ce pseudo est déjà pris";
	    				}else{
	    					//on update les infos du vendeur
	    					$sqlUpdateTexte = "UPDATE vendeur SET Pseudo = '".$newPseudo."', Description = '".$newDescription."' where Pseudo like '%$pseudoConnected%'";
	    					$resultatUpdateTexte = mysqli_query($db_handle,$sqlUpdateTexte) or die (mysqli_error($db_handle));
	    					$_SESSION["pseudoConnected"] = $newPseudo;
	    					header('Location: profil_vendeur_prive.php');
	    				}
    				}
    			}
    		}
    	}
    }

    if (isset($_POST["boutonImageProfil"]) && $db_found) {
    	if($_POST["boutonImageProfil"]){
    		/*$newImageFond = "";
    		if($newImageFond == "NULL"){
    			$sqlUpdateProfil = "UPDATE vendeur SET Photo = NULL where Pseudo like %$pseudoConnected%'";
    		}else{
    			//on teste les caractères spéciaux
    			$pattern= '/[\'^£$%&*()}{@#~?><>,|=+¬éàèùüïûç]/';
    			if (preg_match($pattern, $newImageFond) == 1) {
    				echo "<script>alert(\"Adresse non sauvegardeé : l'adresse ne doit pas contenir de caractères spéciaux et ne peut pas être vide\")</script>";
    			}else{

    				// requête pour changer l'image dans la bdd
    				$sqlUpdateProfil = "UPDATE vendeur SET Photo = '".$newImageFond."' where Pseudo like '%$pseudoConnected%'";
    				$resultatUpdateProfil = mysqli_query($db_handle,$sqlUpdateProfil) or die (mysqli_error($db_handle));
    			}	
    		}*/
    	}
    }

 ?>

<!DOCTYPE html>
<html>
	<head>
		<title>Profil du vendeur</title>
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
		<link rel="stylesheet" type="text/css" href="Styles/profil-vendeur-prive.css">
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

	
		<?php echo '<div class="container-fluid" id="conteneur" style="background-image: url(\''.(isset($dataInfosVendeur["ImageFond"])?$dataInfosVendeur["ImageFond"]:"Images/fond-profil-default.jpg").'\');">'; ?>
			<div class="row container-fluid" id="contenu">
				<div class="row" id="infosVendeur">
					<div class="col-md-4 col-sm-12 conteneurImage" style="height: 300px">
						<?php echo '<img id="photoVendeur" src="'.(isset($dataInfosVendeur["Photo"])?$dataInfosVendeur["Photo"]:"Images/photo-vendeur-default.jpg").'" class="imagesExemples">'; ?>
						<form action="profil_vendeur_prive.php" method="post">
							<input type="submit" name="boutonImageProfil" id="changerImage" class="btn btn-warning col-12" value="Changer l'image de profil">
						</form>
					</div>
					<div class="col-md-1 col-sm-12" style="height: 50px;"></div>
					<div class="col-md-7 col-sm-12" id="infosTexte">
						<div class="container-fluid" style="height: 100%">
							<div class="row" id="nomVendeur" style="height:auto;">
								Pseudo : <textarea class="col-12" rows="2" name="newPseudo" form="formTexte"><?php echo $dataInfosVendeur["Pseudo"]; ?></textarea>
							</div>
							<div class="row" id="description">
								Description : <textarea rows="6" name="newDescription" form="formTexte"><?php echo (isset($dataInfosVendeur["Description"])?$dataInfosVendeur["Description"]:""); ?></textarea>
							</div>
							<div class="row">
								<form id="formTexte" action="profil_vendeur_prive.php" method="post">
								<input type="submit" name="buttonSaveText" class="btn btn-warning col-12" id="sauverInfosTexte" value="Sauvegarder les informations">
								</form>
							</div>
							<?php echo "<p>".$erreurTexte."</p>"; ?>
						</div>
					</div>
				</div>

				<input type="text" name="newImageFond" form="formImageFond" value="" >
				<!--ajouter form et input-->
				<form action="profil_vendeur_prive.php" method="post" id="formImageFond">
					
					<div class="row text-center">
						<input type="submit" name="boutonImageFond" id="changerImageFond" class="btn btn-warning col-12" value="Changer l'image de fond">
					</div>
				</form>

				<div class="row" id="exemplesProduits">
					<?php 
                        $sqlPhotos = "SELECT * from produit where PseudoVendeur like '%$pseudoConnected%' LIMIT 3";
                        $resultPhotos = mysqli_query($db_handle,$sqlPhotos) or die (mysqli_error($db_handle));
                        while ($dataPhotos = mysqli_fetch_assoc($resultPhotos)) {   //adapter lien vers produits
                            echo '
                                <div class="col-md-3 col-sm-12 conteneurImage">
                                    <a href="produit_vendeur.php?numeroProduit='.$dataPhotos["Numero"].'"><img src="'.$dataPhotos["Photo1"].'" class="imagesExemples"></a>    
                                </div>
                            ';
                        }
                     ?>
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