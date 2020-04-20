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
    $dataInfosClient = "";
    if($db_found){
      $sqlInfosClient = "SELECT * from acheteur where IDAcheteur =".$idConnected;
      $resultInfosClient = mysqli_query($db_handle,$sqlInfosClient) or die (mysqli_error($db_handle));
      if(mysqli_num_rows($resultInfosClient) == 0){
        echo "Erreur : le client n'a pas été trouvé";
      }else{
        $dataInfosClient = mysqli_fetch_assoc($resultInfosClient);
      }
    }

    $erreurSauvegarder = "";
    if(isset($_POST["boutonSauvegarder"]) && $db_found){
      if($_POST["boutonSauvegarder"]){
        //On récupère les informations du form
        $verifNom = isset($_POST["Nom"])?$_POST["Nom"]:"";
        $verifPrenom = isset($_POST["Prenom"])?$_POST["Prenom"]:"";
        $verifAdresseMail = isset($_POST["AdresseMail"])?$_POST["AdresseMail"]:"";
        $verifAdresseLigne1 = isset($_POST["AdresseLigne1"])?$_POST["AdresseLigne1"]:"";
        $verifAdresseLigne2 = isset($_POST["AdresseLigne2"])?$_POST["AdresseLigne2"]:"";
        $verifVille = isset($_POST["Ville"])?$_POST["Ville"]:"";
        $verifCodePostal = isset($_POST["CodePostal"])?$_POST["CodePostal"]:"";
        $verifPays = isset($_POST["Pays"])?$_POST["Pays"]:"";
        $verifNumeroTelephone = isset($_POST["NumeroTelephone"])?$_POST["NumeroTelephone"]:"";

        if($verifNom == "" || $verifPrenom == "" || $verifAdresseMail == "" || $verifAdresseLigne1 == "" || $verifVille == "" || $verifCodePostal == "" || $verifPays == "" || $verifNumeroTelephone == ""){
          echo "<script>alert(\"Données non sauvegardées : tous les champs doivent être remplis\")</script>";
          $erreurSauvegarder = "Tous les champs doivent être remplis !";
        }else{
          //On vérifie qu'il n'y a pas de caractères spéciaux
          $pattern= '/[\'^£$%&*()}{@#~?><>,|=_+¬-éàèùüïûç]/';
          if(preg_match($pattern, $verifNom) || preg_match($pattern, $verifPrenom) || preg_match('/[\'^£$%&*()}{#~?><>,|=_+¬-éàèùüïûç]/', $verifAdresseMail) || preg_match($pattern, $verifAdresseLigne1) || preg_match($pattern, $verifAdresseLigne2) || preg_match($pattern, $verifVille) || preg_match($pattern, $verifCodePostal) || preg_match($pattern, $verifPays) || preg_match('/[\'^£$%&*()}{@~?><>,|=_¬-éàèùüïûç]/', $verifNumeroTelephone)){
              echo "<script>alert(\"Données non sauvegardeés : les champs ne doivent pas contenir de caractères spéciaux (excepté le @ de l'adresse mail et le + du numéro de téléphone)\")</script>";
              $erreurSauvegarder = "Les champs ne doivent pas contenir de caractère spéciaux (excepté le @ de l'adresse mail et le + du numéro de téléphone)";
          }else{
            //TODO : autres vérifications des champs

            //L'adresse 'mail étant l'identifiant, on va vérifier qu'il n'y a pas d'autre compte avec la même adresse mail
            $sqlVerifMail = "SELECT * from acheteur where AdresseMail like '%$verifAdresseMail%' and IDAcheteur != ".$idConnected;
            $resultatVerifMail = mysqli_query($db_handle,$sqlVerifMail) or die (mysqli_error($db_handle));
            if(mysqli_num_rows($resultatVerifMail) != 0){
              echo "<script>alert(\"Données non sauvegardeés : cette adresse mail est déjà utilisée par un autre client\")</script>";
              $erreurSauvegarder = "Cette adresse mail est déjà utilisée par un autre client";
            }else{

              //On update les infos du client
              $sqlUpdate = "UPDATE acheteur
                            Set Prenom = '".$verifPrenom."',
                                Nom = '".$verifNom."',
                                AdresseMail = '".$verifAdresseMail."',
                                AdresseLigne1 = '".$verifAdresseLigne1."' ,
                                AdresseLigne2 = '".$verifAdresseLigne2."' ,
                                Ville = '".$verifVille."',
                                CodePostal = '".$verifCodePostal."' ,
                                Pays = '".$verifPays."',
                                Telephone = '".$verifNumeroTelephone."'
                            where IDAcheteur = ".$idConnected;
              $resultatUpdate = mysqli_query($db_handle,$sqlUpdate) or die (mysqli_error($db_handle));
              header('Location: profil_client.php');
            }
          }
        }
      }
    }
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


	<div style="height: 1500px;">
		<!-- <div class="container"> -->
		<br>
			<!-- <button id="savebtn" class="btn btn-primary btn-lg btn-block">Sauvegarder les changements</button> -->
			<!-- </div> -->
    <?php echo $erreurSauvegarder; ?>
    <form action="profil_client.php" method="post">
  		<input type="submit" name="boutonSauvegarder" id="myBtn" class="btn btn-primary btn-lg btn-block" value="Sauvegarder vos modifications">
      
  		<br>
  		<!-- </div> -->
  		<div class="row" id="ensemble">
  			<div class="col-sm-10" style="background-color:#aaa;">
  				<h2>Prénom</h2>
  				<?php echo '<input type="text" name="Prenom" value="'.$dataInfosClient["Prenom"].'" >'; ?>
  			</div>
  		</div>
  		<br>
  		<div class="row" id="ensemble">
  			<div class="col-sm-10" style="background-color:#aaa;">
  				<h2>Nom</h2>
  				<?php echo '<input type="text" name="Nom" value="'.$dataInfosClient["Nom"].'" >'; ?>
  			</div>
  		</div>
  		<br>
  		<div class="row" id="ensemble">
  			<div class="col-sm-10" style="background-color:#aaa;">
  				<h2>Adresse Mail</h2>
  				<?php echo '<input type="text" name="AdresseMail" value="'.$dataInfosClient["AdresseMail"].'" >'; ?>
  			</div>
  		</div>
  		<br>
  		<div class="row" id="ensemble">
  			<div class="col-sm-10" style="background-color:#aaa;">
  				<h2>Adresse 1</h2>
  				<?php echo '<input type="text" name="AdresseLigne1" value="'.$dataInfosClient["AdresseLigne1"].'" >'; ?>
  			</div>
  		</div>
  		<br>
  		<div class="row" id="ensemble">
  			<div class="col-sm-10" style="background-color:#aaa;">
  				<h2>Adresse 2</h2>
  				<?php echo '<input type="text" name="AdresseLigne2" value="'.$dataInfosClient["AdresseLigne2"].'" >'; ?>
  			</div>
  		</div>
  		<br>
  		<div class="row" id="ensemble">
  			<div class="col-sm-10" style="background-color:#aaa;">
  				<h2>Ville</h2>
  				<?php echo '<input type="text" name="Ville" value="'.$dataInfosClient["Ville"].'" >'; ?>
  			</div>
  		</div>
  		<br>
  		<div class="row" id="ensemble">
  			<div class="col-sm-10" style="background-color:#aaa;">
  				<h2>Code Postal</h2>
  				<?php echo '<input type="text" name="CodePostal" value="'.$dataInfosClient["CodePostal"].'" >'; ?>
  			</div>
  		</div>
  		<br>
  		<div class="row" id="ensemble">
  			<div class="col-sm-10" style="background-color:#aaa;">
  				<h2>Pays</h2>
  				<?php echo '<input type="text" name="Pays" value="'.$dataInfosClient["Pays"].'" >'; ?>
  			</div>
  		</div>
  		<br>
  		<div class="row" id="ensemble">
  			<div class="col-sm-10" style="background-color:#aaa;">
  				<h2>Téléphone</h2>
  				<?php echo '<input type="text" name="NumeroTelephone" value="'.$dataInfosClient["Telephone"].'" >'; ?>
  			</div>
  		</div>
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
	</body>

	
</html>