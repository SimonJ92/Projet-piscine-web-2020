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
	$erreurCreation ="";
	$erreurCreationBancaire="";
	
	if (isset($_POST["boutonCreation"])) {
		if($_POST["boutonCreation"] && $db_found){
			
			//Information Générales Clients
			
			$creationPrenom = isset($_POST["creationPrenom"])? $_POST["creationPrenom"]:"";
			$creationNom = isset($_POST["creationNom"])? $_POST["creationNom"]:"";
			$creationMail = isset($_POST["creationMail"])? $_POST["creationMail"]:"";
			$creationMdp = isset($_POST["creationMdp"])? $_POST["creationMdp"]:"";
			$creationAdresse1 = isset($_POST["creationAdresse1"])? $_POST["creationAdresse1"]:"";
			$creationAdresse2 = isset($_POST["creationAdresse2"])? $_POST["creationAdresse2"]:"";
			$creationVille = isset($_POST["creationVille"])? $_POST["creationVille"]:"";
			$creationZip = isset($_POST["creationZip"])? $_POST["creationZip"]:"";
			$creationPays = isset($_POST["creationPays"])? $_POST["creationPays"]:"";
			$creationPhone = isset($_POST["creationPhone"])? $_POST["creationPhone"]:"";
			$creationNumber = isset($_POST["creationNumber"])? $_POST["creationNumber"]:"";
			
			//Informations Bancaires
			
			$creationTitulaire = isset($_POST["creationTitulaire"])? $_POST["creationTitulaire"]:"";
			$creationTypeCarte = isset($_POST["creationradio"])? $_POST["creationradio"]:"";
			$creationME = isset($_POST["creationME"])? $_POST["creationME"]:"";
			$creationAE = isset($_POST["creationAE"])? $_POST["creationAE"]:"";
			$creationSecurite = isset($_POST["creationSecurite"])? $_POST["creationSecurite"]:"";
			
			if($creationPrenom=="" || $creationNom=="" || $creationMail=="" || $creationMdp=="" || $creationAdresse1=="" || $creationVille=="" || $creationZip=="" || $creationPays=="" || $creationPhone=="" || $creationNumber=="" || $creationTitulaire=="" || $creationTypeCarte=="" || $creationME=="" || $creationAE=="" || $creationSecurite=="") {
				$erreurCreation= "Tous les champs doivent être remplis";
			}else{
				$sqlTestCreation = "SELECT * FROM acheteur WHERE AdresseMail like '%$creationMail%'";
				$resultTestCreation = mysqli_query($db_handle,$sqlTestCreation) or die (mysqli_error($db_handle));
				if(mysqli_num_rows($resultTestCreation) != 0){
					$erreurCreation = "Cette email est déjà utilisé";
				}else{
					$sqlCreation = "INSERT INTO acheteur (Prenom,Nom,AdresseMail,AdresseLigne1,AdresseLigne2,Ville,CodePostal,Pays,Telephone,MotDePasse) VALUES ('$creationPrenom','$creationNom','$creationMail','$creationAdresse1','$creationAdresse2','$creationVille','$creationZip','$creationPays','$creationPhone','$creationMdp')";
					$resultCreation = mysqli_query($db_handle,$sqlCreation);
					
					$sqlCreationBancaire = "INSERT INTO carte (NumeroCarte,NomTitulaire,TypeCarte,MoisExpiration,AnneeExpiration,CodeSecurite,Solde) VALUES ('$creationNumber','$creationTitulaire','$creationTypeCarte','$creationME','$creationAE','$creationSecurite','1000')";
					$resultCreationBancaire = mysqli_query($db_handle,$sqlCreationBancaire);
					
					$sqlupdate = "UPDATE acheteur SET NumeroCarte = '$creationNumber' WHERE AdresseMail like '$creationMail' ";
					$resultsqlupdate = mysqli_query($db_handle,$sqlupdate);
					
					echo "resultat : ".$resultCreation;
					
					$erreurCreation  = "Profil créé";
					$erreurCreationBancaire = "Information Bancaire enregistré";
				}
			}
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Inscription</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<link rel="stylesheet" href="Styles/style.css">
		<link rel="stylesheet" href="Styles/MyFooter.css">
		<link rel="stylesheet" href="Styles/nav_bar.css">
		
		<link rel="stylesheet" type="text/css" href="Styles/infos.css">
		<link rel="icon" href="Images/favicon.ico" type="images/x-icon">
		<script src="Scripts/inscription_client.js"></script>
		<link rel="stylesheet" type="text/css" href="Styles/inscription_client.css">
		<link rel="stylesheet" href="Styles/bootstrap.min.css">
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


	<!-- 00 -->
	<!-- DIV -->
	<!-- 00 -->
	<div class="container-fluid">
		<div>
			<h1 id="titrePrincipal" align="center"><strong>Inscription</strong></h1>
		</div>
		<div class="row conteneurInfos">
			<div class="container-fluid">
				<form action="inscription_client.php" method="post" id="formCreation" >
					<h3><b>Informations générales</b> </h3>
					<div class="form-group">
						<label for="prenom">Prénom</label>
						<input type="text" class="form-control" name="creationPrenom" id="creationPrenom" placeholder="Saisir votre prénom">
					</div>
					
					<div class="form-group">
						<label for="nom">Nom</label>
						<input type="text" class="form-control" name="creationNom" id="creationNom" placeholder="Saisir votre nom">
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="mail">Adresse Mail</label>
							<input type="email" class="form-control" name="creationMail" id="creationMail" placeholder="Saisir votre adresse mail">
							<small id="mailAide" class="form-text text-muted">Nous ne partagerons jamais votre adresse mail sans votre autorisation.</small>
						</div>
					
						<div class="form-group col-md-6">
							<label for="mdp">Mot de Passe</label>
							<input type="password" class="form-control" name="creationMdp" id="creationMdp" placeholder="Saisir votre mot de passe">
						</div>
					</div>
					<div class="form-group">
						<label for="adresse1">Adresse 1</label>
						<input type="text" class="form-control" name="creationAdresse1" id="creationAdresse1" placeholder="Saisir votre adresse">
					</div>
					
					<div class="form-group">
						<label for="adresse2">Adresse 2</label>
						<input type="text" class="form-control" name="creationAdresse2" id="creationAdresse2" placeholder="Saisir votre complément d'adresse">
					</div>
					
					<div class="form-row">
						<div class="form-group col-6">
							<label for="ville">Ville</label>
							<input type="text" class="form-control" name="creationVille" id="creationVille" placeholder="Saisir votre ville">
						</div>
						<div class="form-group col">
							<label for="zip">Code Postal</label>
							<input type="text" class="form-control" name="creationZip" id="creationZip" placeholder="Saisir votre code postal">
						</div>
						<div class="form-group col">
							<label for="pays">Pays</label>
							<input type="text" class="form-control" name="creationPays" id="creationPays" placeholder="Saisir votre pays">
						</div>
					</div>
					
					<div class="form-group">
						<label for="phone">Numéro de téléphone</label>
						<input type="text" class="form-control" name="creationPhone" id="creationPhone" placeholder="Saisir votre numéro de téléphone">
					</div>
					
					<h3><b> Informations de paiement </b></h3>
					
					<div class="form-group">
							<label for="titulaire">Nom du titulaire</label>
							<input type="text" class="form-control" name="creationTitulaire" id="creationTitulaire" placeholder="Saisir le nom du titulaire de la carte">
					</div>
					
					<div class="form-row">
						
						<div class="form-group col-8">
							<label for="number">Numéro de carte</label>
							<input type="text" class="form-control" name="creationNumber" id="creationNumber" placeholder="Saisir votre numéro de carte bancaire">
						</div>
						<div class="form-group col">
							<label for="ME">Mois d'Expiration</label>
							<input type="text" class="form-control" name="creationME" id="creationME" placeholder="Saisir la date d'expiration">
						</div>
						<div class="form-group col">
							<label for="AE">Année d'Expiration</label>
							<input type="text" class="form-control" name="creationAE" id="creationAE" placeholder="Saisir l'année d'expiration">
						</div>
						<div class="form-group col">
							<label for="Securite">Code de sécurité</label>
							<input type="text" class="form-control" name="creationSecurite" id="creationSecurite" placeholder="Saisir le code de sécurité">
						</div>
					</div>
					<fieldset class="form-group">
						<div class="row">
							<legend class="col-form-label col-sm-2 pt-0">Type de carte/paiement</legend>
								<div class="col-sm-10">
									<div class="form-check">
										<input class="form-check-input" type="radio" name="creationradio" id="creationradio" value="Visa" checked>
										<label class="form-check-label" for="gridRadios1">
										Visa
										</label>
									</div>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="creationradio" id="creationradio" value="MasterCard">
										<label class="form-check-label" for="gridRadios2">
										MasterCard
										</label>
									</div>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="creationradio" id="creationradio" value="American Express">
										<label class="form-check-label" for="gridRadios3">
										American Express
										</label>
									</div>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="creationradio" id="creationradio" value="PayPal">
										<label class="form-check-label" for="gridRadios4">
										PayPal
										</label>
									</div>
								</div>
						</div>
					</fieldset>
					
					
					<div class="form-group">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" id="gridCheck" onChange="affichebouton(gridCheck)">
							<label class="form-check-label" for="gridCheck">
								Je certifie avoir pris connaissance des conditions d'utilisations.
							</label>
						</div>
					</div>
					
					<div id="boutondisabled">
						<button type="submit" class="btn btn-sm btn-primary" disabled display="none">Créer mon compte</button>
					</div>
					<div id="bouton">
						<input type="submit" name="boutonCreation" id="boutonCreation" class="btn btn-sm btn-primary" onclick="creation()" value="Créer mon compte">
					</div>
					<div class="form-group">
						<p>    </p>
					</div>
					<?php echo "	$erreurCreation"; ?>
					<?php echo "    $erreurCreationBancaire"; ?>
				</form>
			</div>
		</div>
		<div class="row" id="espacement"></div>
		

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
