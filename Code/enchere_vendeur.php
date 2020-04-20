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
    $numeroProduit = isset($_GET["numeroProduit"])?$_GET["numeroProduit"]:"";
    $dataProduit = "";
    $erreurProduit = "";
    $dataEnchere = "";
    $erreurEnchere = "";
    if($db_found){
    	$sqlProduit = "SELECT * from produit where Numero = $numeroProduit";
    	$resultatProduit = mysqli_query($db_handle,$sqlProduit) or die (mysqli_error($db_handle));
    	if(mysqli_num_rows($resultatProduit) == 0){
    		$erreurProduit = "Erreur : produit non trouvé dans la base de données";
    	}else{
    		$dataProduit = mysqli_fetch_assoc($resultatProduit);
    	}
    }
    if($db_found){
    	$sqlProduit = "SELECT * from produit where Numero = $numeroProduit";
    	$resultatProduit = mysqli_query($db_handle,$sqlProduit) or die (mysqli_error($db_handle));
    	if(mysqli_num_rows($resultatProduit) == 0){
    		$erreurProduit = "Erreur : produit non trouvé dans la base de données";
    	}else{
    		$dataProduit = mysqli_fetch_assoc($resultatProduit);
    	}
    }

    if($db_found){
    	$sqlEnchere = "SELECT * from enchere where NumeroProduit = $numeroProduit";
    	$resultatEnchere = mysqli_query($db_handle,$sqlEnchere) or die (mysqli_error($db_handle));
    	if(mysqli_num_rows($resultatEnchere) == 0){
    		$erreurProduit = "Erreur : enchère non trouvée dans la base de données";
    	}else{
    		$dataEnchere = mysqli_fetch_assoc($resultatEnchere);
    		echo '<script>var dateFinEnchere = "'.$dataEnchere["DateFin"].'";</script>';
    	}
    }

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
		<link rel="stylesheet" type="text/css" href="Styles/enchere_vendeur.css">
		<!--<script src="Scripts/enchere_vendeur.js"></script>-->
		<script>
			// Set the date we're counting down to
			
			var countDownDate = new Date(dateFinEnchere).getTime();

			// Update the count down every 1 second
			var x = setInterval(function() {

			  // Get today's date and time
			  var now = new Date().getTime();
			    
			  // Find the distance between now and the count down date
			  var distance = countDownDate - now;
			    
			  // Time calculations for days, hours, minutes and seconds
			  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
			    
			  // Output the result in an element with id="demo"
			  document.getElementById("dateenchere").innerHTML = days + "d " + hours + "h "
			  + minutes + "m " + seconds + "s ";
			    
			  // If the count down is over, write some text 
			  if (distance < 0) {
			    clearInterval(x);
			    document.getElementById("dateenchere").innerHTML = "L\'enchère est terminée";
			  }
			}, 1000);
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
	<!-- ENTRESITE -->
	<!-- 00 -->
	
	<div class="wrapper">
		<div class="produit_now">
			<ul class="list-unstyled">
				<?php 
					//On veut afficher toutes les enchères des produits que vent le vendeur
					$sqlMesEncheres = "SELECT E.* from enchere E join Produit Pr on Pr.Numero = E.NumeroProduit where Pr.PseudoVendeur like '%$pseudoConnected%'";
					$resultatMesEncheres = mysqli_query($db_handle,$sqlMesEncheres) or die (mysqli_error($db_handle));
					if(mysqli_num_rows($resultatMesEncheres) == 0){
						echo "Pas d'enchère trouvée";
					}else{
						while ($dataMesEncheres = mysqli_fetch_assoc($resultatMesEncheres)) {
							$sqlProduitMesEncheres = "SELECT * from produit where Numero =".$dataMesEncheres["NumeroProduit"];
							$resultatProduitMesEncheres = mysqli_query($db_handle,$sqlProduitMesEncheres) or die (mysqli_error($db_handle));
							if(mysqli_num_rows($resultatProduitMesEncheres) == 0){
								echo "Erreur lors de la récupéraiton du produit";
							}else
							{
								$dataProduitMesEncheres = mysqli_fetch_assoc($resultatProduitMesEncheres);
								echo '
									<li class="media">
										<a href="enchere_vendeur.php?numeroProduit='.$dataMesEncheres["NumeroProduit"].'"><img class="mr-3" src="'.$dataProduitMesEncheres["Photo1"].'" alt="Generic placeholder image" style="max-height: 150px;max-width: 150px;"></a>
										<div class="media-body">
											<h5 class="mt-0 mb-1">List-based media object</h5>
												'.$dataProduitMesEncheres["DescriptionCourte"].'
										</div>
									</li>
								';
							}
						}
					}
				 ?>
				
			</ul>
		</div>
		<div class="information">
			<div class="row">
				<div class="col-lg-6">
					<?php echo $erreurProduit; ?>
					<?php echo '<a href="produit_vendeur.php?numeroProduit='.$numeroProduit.'">' ?>
						<h3><b><?php echo $dataProduit["Nom"] ?></b></h3>
					</a>
				</div>
				<div class="col-lg-6">
					<h3><?php echo (($dataProduit["Categorie"] == "Ferraille")?"Ferraille et trésors":(($dataProduit["Categorie"] == "Musee")?"Bon pour le musée":"Accessoires VIP")); ?></h3>
				</div>
				<div class="col-lg-3" style="background-color:inherit"></div>
			</div>
			<div class="row">
				<div class="col-lg-3" id="ok">
				<?php echo '<a href="produit_vendeur.php?numeroProduit='.$numeroProduit.'">' ?>
					<?php echo '<img class="imageProduit center" src="'.$dataProduit["Photo1"].'" style="max-height: 600px; max-width: 250px;">'; ?>
				</a>
				</div>
				<div class="col-lg-8" style="background-color:white">
				<h3>Description</h3>
				<p><?php echo $dataProduit["DescriptionCourte"]; ?></p>
				</div>
			</div>
			<div class="row">
				<br><p></p><br><br>
			</div>
		</div>
		
		<div class="container">
			<div class="container-fluid">
				<?php echo $erreurEnchere; ?>
				<div class="col-lg-9">
					<h3>L'enchère se terminera le :</h3>
					<span id="DateE"><?php echo $dataEnchere["DateFin"]; ?></span> 
				</div>
				<div class="col-lg-3" style="background-color:white"></div>
				<div class="col-lg-5">
					<h3> Fin enchère dans : <br> </h3>
					<p id="dateenchere"></p>
				</div>
			</div>
			<div class="container-fluid">
				<div class="col-lg-9">
					<h3>Meilleure offre actuelle</h3>
					<?php 
						//chercher la meilleure offre
						if($db_found){
							$sqlMeilleureOffre = "SELECT A.* from offre A where A.IDEnchere = ".$dataEnchere['IDEnchere']." order by A.Valeur desc, A.DateOffre asc limit 1";
							$resultatMeilleureOffre = mysqli_query($db_handle,$sqlMeilleureOffre) or die (mysqli_error($db_handle));
							if(mysqli_num_rows($resultatMeilleureOffre) == 0){
								echo '<p id="prix">Pas d\'offre pour l\'instant</p>';
							}else{
								$dataMeileureOffre = mysqli_fetch_assoc($resultatMeilleureOffre);
								echo '<p id="prix">'.$dataMeileureOffre["Valeur"].'€</p>';
							}
						}
					 ?>
				</div>
				<div class="col-lg-3" style="background-color:white"></div>
				<div class="col-lg-5">
					<div class="row">
						<div class="col">
							<h3>Nombres d'offres effectués</h3>
							<?php 
								//chercher la meilleure offre
								if($db_found){
									$sqlNombreOffre = "SELECT count(*) as compte from offre A where A.IDEnchere = ".$dataEnchere['IDEnchere'];
									$resultatNombreOffre = mysqli_query($db_handle,$sqlNombreOffre) or die (mysqli_error($db_handle));
									if(mysqli_num_rows($resultatNombreOffre) == 0){
										echo '<p id="prix">Pas d\'offre pour l\'instant</p>';
									}else{
										$dataNombreOffre = mysqli_fetch_assoc($resultatNombreOffre);
										echo '<p id="prix">'.$dataNombreOffre["compte"].'</p>';
									}
								}
							 ?>
							<p id="offre"></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid">
		<h3>Règlement des enchères </h3>
		<p> La vente aux enchère peut être proposée par le vendeur s'il le souhaite. Celui-ci definira une date de fin d'enchère, jusqu'à laquelle chaque utilisateur a la possibilité de faire une unique offre du montant de son choix. Une fois la date limite atteinte, l'utilisateur qui aura fait l'offre la plus élevée est déclaré gagnant de l'enchère. Dans le cas où plusieurs utilisateurs feraient la même offre, seul le premier d'entre eux à effectuer l'offre en question sera déclaré gagnant. La somme à payer pour le gagnant sera la somme minimale, inférieure ou égale à la valeur de son offre, requise pour surpasser toutes les autres offres. </p>					
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