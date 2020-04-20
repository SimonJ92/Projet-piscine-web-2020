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
 ?>

<!DOCTYPE html>
<html>
	<head>
		<title>Enchère</title>
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
		<link rel="stylesheet" type="text/css" href="Styles/enchere_client.css">
		<script src="Scripts/enchere_client.js"></script>
		<link rel="icon" href="Images/favicon.ico" type="images/x-icon">
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
	
	
		<div class="wrapper">
			<div class="produit_now">
				<ul class="list-unstyled">
					<li class="media">
						<a href="#"><img class="mr-3" src="..." alt="Generic placeholder image"></a>
						<div class="media-body">
							<h5 class="mt-0 mb-1">List-based media object</h5>
								Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
						</div>
					</li>
					<li class="media my-4">
						<a href="#"><img class="mr-3" src="..." alt="Generic placeholder image"></a>
						<div class="media-body">
							<h5 class="mt-0 mb-1">List-based media object</h5>
								Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
						</div>
					</li>
					<li class="media">
						<a href="#"><img class="mr-3" src="..." alt="Generic placeholder image"></a>
						<div class="media-body">
							<h5 class="mt-0 mb-1">List-based media object</h5>
							Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
						</div>
					</li>
					<li class="media">
						<a href="#"><img class="mr-3" src="..." alt="Generic placeholder image"></a>
						<div class="media-body">
							<h5 class="mt-0 mb-1">List-based media object</h5>
							Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
						</div>
					</li>
					<li class="media">
						<a href="#"><img class="mr-3" src="..." alt="Generic placeholder image"></a>
						<div class="media-body">
							<h5 class="mt-0 mb-1">List-based media object</h5>
							Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
						</div>
					</li>
				</ul>
			</div>
			<div class="information">
				<div class="row">
					<div class="col-lg-6">
						<a href="#"><h3><b>Nom du produit</b></h3></a>
					</div>
					<div class="col-lg-6">
						<h3>Catégorie du produit</h3>
					</div>
					<div class="col-lg-3" style="background-color:inherit"></div>
				</div>
				<div class="row">
					<div class="col-lg-3" id="ok">
					<a href="#"><img class="imageProduit center" src="Images/logo.png"></a>
					</div>
					<div class="col-lg-8" style="background-color:white">
					<h3>Description</h3>
					<p>Blabla Blabla Blabla Blabla Blabla Blabla Blabla Blabla Blabla Blabla Blabla Blabla Blabla Blabla Blabla Blabla Blabla </p>
					</div>
				</div>
				<div class="row">
					<br><p></p><br><br>
				</div>
				<div class="information_vendeur">
					<div class="row">
						<div class="col-sm-2" style="background-color:inherit"></div>
						<div class="col">
							<a href="#"><h3>Vendeur</h3></a>
						</div>
						<div class="col">
							<a href="#"><h3>Lien vers le site du vendeur</h3></a>
						</div>
					</div>
				</div>
			</div>
			
			<div class="container">
			<div class="container-fluid">
				<div class="col-lg-9">
					<h3>L'enchère se terminera le :</h3>
					<p id="DateE"></p> 
				</div>
				<div class="col-lg-3" style="background-color:white"></div>
				<div class="col-lg-5">
					<h3> Fin enchère dans : <br> </h3>
					<p id="dateenchere"></p>
				</div>
			</div>
			<div class="container-fluid">
				<div class="col-lg-9">
					<div id="divencheredisabled">
					<h3>Mon enchère</h3>
					<form>
						<fieldset disabled>
							<div class="form-group">
								<label for="enchere">Mon enchère: </label>
								<input type ="text" class="form-control" id="encheredisabled" name="enchere" placeholder="Saisir votre enchère">
								<small class="form-text text-muted">Attention une seule enchère maximale possible.</small>
							</div>
						</fieldset>
					</form>
					</div>
					<div id="divenchere" style="display:none">
					<h3>Mon	enchère </h3>
					<form>
						<div class="form-group">
								<label for="enchere">Mon enchère: </label>
								<input type ="text" class="form-control" id="enchere" name="enchere" placeholder="Saisir votre enchère">
								<small class="form-text text-muted">Attention une seule enchère maximale possible.</small>
						</div>
					</form>
					</div>
				</div>
				<div class="col-lg-3" style="background-color:white"></div>
				<div class="col-lg-5">
					<div class="row">
						<div class="col">
							<a href="#"><button class="btn btn-block btn-success" >Acheter Maintenant </button></a>
						</div>
						<div class="col">
							PRIX : 
							<p id="prix"></p>
						</div>
					</div>
				</div>
			</div>
			</div>
			<div class="container-fluid">
			<h3>Règlement des enchères </h3>
			<p> La vente aux enchère peut être proposée par le vendeur s'il le souhaite. Celui-ci definira une date de fin d'enchère, jusqu'à laquelle chaque utilisateur a la possibilité de faire une unique offre du montant de son choix. Une fois la date limite atteinte, l'utilisateur qui aura fait l'offre la plus élevée est déclaré gagnant de l'enchère. Dans le cas où plusieurs utilisateurs feraient la même offre, seul le premier d'entre eux à effectuer l'offre en question sera déclaré gagnant. La somme à payer pour le gagnant sera la somme minimale, inférieure ou égale à la valeur de son offre, requise pour surpasser toutes les autres offres. </p>
			<form>
				<div class="form-group">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" id="gridCheck" onChange="afficheenchere(gridCheck)">
						<label class="form-check-label" for="gridCheck">
									Je certifie avoir pris connaissance des conditions d'utilisations.
						</label>
					</div>
				</div>
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
	</body>

	
</html>