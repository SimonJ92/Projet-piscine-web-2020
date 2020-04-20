<?php 
	//En tête
    session_start();

    $db_handle = mysqli_connect('localhost', 'root', ''); 
    $db_found = mysqli_select_db($db_handle, "ebay_ece");

    $typeConnected=(isset($_SESSION['typeConnected']))?(int) $_SESSION['typeConnected']:1;
    //visiteur : 1
    //client : 2
    //vendeur : 3
    $idConnected=(isset($_SESSION['idConnected']))?(int) $_SESSION['idConnected']:'';
    //id si client connecté
    $pseudoConnected=(isset($_SESSION['pseudoConnected']))?$_SESSION['pseudoConnected']:'';
    //pseudo si vendeur connecté
	
	//produitouvert
	$produitConnected=(isset($_SESSION['idproduit']))?(int) $_SESSION['idproduit']:'';
    
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
	
	
	$erreurOffre ="";
	$erreurAccept ="";
	
	if (isset($_POST["boutonoffre"])) {
		if($_POST["boutonoffre"] && $db_found){
			
			$nouvelleoffre = isset($_POST["nouvelleoffre"])? $_POST["nouvelleoffre"]:"";
			
			if($nouvelleoffre==""){
				$erreurOffre ="Saisir une offre";
			}else{
				$sqlTestCreation = "SELECT * FROM negociation WHERE (IDAcheteur like '%$idConnected%' AND NumeroProduit like '%$produitConnected%')";
				$resultTestCreation = mysqli_query($db_handle,$sqlTestCreation) or die (mysqli_error($db_handle));
				
				if(mysqli_num_rows($resultTestCreation) != 0){
					$erreurOffre =  "Négociations déjà entamé.";
					$sqlTestOffre1 = "SELECT  * FROM negociation  WHERE (IDAcheteur like '%$idConnected%' AND Prop2 IS NULL)";
					$resultTestOffre1 = mysqli_query($db_handle,$sqlTestOffre1) or die (mysqli_error($db_handle));
				
					$sqlTestOffre2 = "SELECT  * FROM negociation  WHERE (IDAcheteur like '%$idConnected%' AND Prop4 IS NULL)";
					$resultTestOffre2 = mysqli_query($db_handle,$sqlTestOffre2) or die (mysqli_error($db_handle));
				
					$sqlTestOffre3 = "SELECT  * FROM negociation  WHERE (IDAcheteur like '%$idConnected%' AND Prop6 IS NULL)";
					$resultTestOffre3 = mysqli_query($db_handle,$sqlTestOffre3) or die (mysqli_error($db_handle));
				
					$sqlTestOffre4 = "SELECT  * FROM negociation  WHERE (IDAcheteur like '%$idConnected%' AND Prop8 IS NULL)";
					$resultTestOffre4 = mysqli_query($db_handle,$sqlTestOffre4) or die (mysqli_error($db_handle));
				
					$sqlTestOffre5 = "SELECT  * FROM negociation  WHERE (IDAcheteur like '%$idConnected%' AND Prop10 IS NULL)";
					$resultTestOffre5 = mysqli_query($db_handle,$sqlTestOffre4) or die (mysqli_error($db_handle));
					
					if(mysqli_num_rows($resultTestOffre1) != 0){
						$sqlOffre = "UPDATE negociation SET Prop2 ='$nouvelleoffre' WHERE (IDAcheteur like '%$idConnected%' AND NumeroProduit like '%$produitConnected%')";
						$resultOffre = mysqli_query($db_handle,$sqlOffre);
						$erreurOffre = "Offre non enregistré";
					}else if(mysqli_num_rows($resultTestOffre2) != 0){
						$sqlOffre = "UPDATE negociation SET Prop4 ='$nouvelleoffre' WHERE (IDAcheteur like '%$idConnected%' AND NumeroProduit like '%$produitConnected%')";
						$resultOffre = mysqli_query($db_handle,$sqlOffre);
						$erreurOffre = "Offre non enregistré";
					}else if(mysqli_num_rows($resultTestOffre3) != 0){
						$sqlOffre = "UPDATE negociation SET Prop6 ='$nouvelleoffre' WHERE (IDAcheteur like '%$idConnected%' AND NumeroProduit like '%$produitConnected%')";
						$resultOffre = mysqli_query($db_handle,$sqlOffre);
						$erreurOffre = "Offre non enregistré";
					}else if(mysqli_num_rows($resultTestOffre4) != 0){
						$sqlOffre = "UPDATE negociation SET Prop8 ='$nouvelleoffre' WHERE (IDAcheteur like '%$idConnected%' AND NumeroProduit like '%$produitConnected%')";
						$resultOffre = mysqli_query($db_handle,$sqlOffre);
						$erreurOffre = "Offre non enregistré";
					}else if(mysqli_num_rows($resultTestOffre5) != 0){
						$sqlOffre = "UPDATE negociation SET Prop10 ='$nouvelleoffre' WHERE (IDAcheteur like '%$idConnected%' AND NumeroProduit like '%$produitConnected%')";
						$resultOffre = mysqli_query($db_handle,$sqlOffre);
						$erreurOffre = "Offre non enregistré";
					} 
					
				}else{
					$sqlOffre = "INSERT INTO negociation (IDAcheteur,PseudoVendeur,NumeroProduit, Prop1,Prop2, Accepted) VALUES ('idConnected','Simon','produitConnected','0','$nouvelleoffre','0')";
					$resultOffre = mysqli_query($db_handle,$sqlOffre);
					$erreurOffre = "Offre non enregistré";
				}
				
			}
		}
	}
	
	if (isset($_POST["accepterbutton"])) {
		if($_POST["accepterbutton"] && $db_found){
			$sqlTestAccept = "SELECT * FROM negociation WHERE (IDAcheteur = $idConnected AND Accepted = '1')";
			$resultTestAccept = mysqli_query($db_handle, $sqlTestAccept);
			if(mysqli_num_rows($resultTestAccept) != 0)
			{
				echo "La négociation est déjà terminé";
			}else{
				$sqlAccepter = "UPDATE negociation SET Accepted = '1' WHERE IDAcheteur = $idConnected";
				$resultAccepter = mysqli_query($db_handle, $sqlAccepter) or die (mysqli_error($db_handle));
			}
		}
	}
 ?>

<!DOCTYPE html>
<html>
	<head>
		<title>Meilleur Offre</title>
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
		<link rel="stylesheet" type="text/css" href="Styles/negoce_client.css">
		<script src="Scripts/negoce_client.js"></script>
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
                            <a class="nav-link" href="panier.php">
                                <img style="max-width:100px;" src="Images/paniers.png">
                            </a>
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
	<!-- ENTRESITE -->
	<!-- 00 -->
	
		<div class="wrapper">
		
			<div class="produit_now">
				<ul class="list-unstyled">
					<li class="media">
						<?php 
							if($db_found){
								$sqlObjetN = "SELECT * FROM produit WHERE MethodeVente LIKE 'Negoce' limit 1";
								$resultObjetN = mysqli_query($db_handle,$sqlObjetN) or die (mysqli_error($db_handle));
								while ($dataObjetN = mysqli_fetch_assoc($resultObjetN)) {
									echo '
										<a href="page_catalogue_client.php?categoriePrduit=2"><img class="mr-3" src="'.$dataObjetN["Photo1"].'" alt="ObjetN1"></a>
										
										<div class="media-body">
							
										<h5 class="mt-0 mb-1"><b>'.$dataObjetN["Nom"].'</b></h5>
											<p> '.$dataObjetN["DescriptionCourte"].'</p>
										</div>
									
									
									';
								}
							}
						?>
					</li>
					<li class="media">
						<?php 
							if($db_found){
								$sqlObjetN = "SELECT * FROM produit WHERE MethodeVente LIKE 'Negoce' limit 1";
								$resultObjetN = mysqli_query($db_handle,$sqlObjetN) or die (mysqli_error($db_handle));
								while ($dataObjetN = mysqli_fetch_assoc($resultObjetN)) {
									echo '
										<a href="page_catalogue_client.php?categoriePrduit=2"><img class="mr-3" src="'.$dataObjetN["Photo1"].'" alt="ObjetN1"></a>
										
										<div class="media-body">
							
										<h5 class="mt-0 mb-1"><b>'.$dataObjetN["Nom"].'</b></h5>
											<p> '.$dataObjetN["DescriptionCourte"].'</p>
										</div>
									
									
									';
								}
							}
						?>
					</li>
					<li class="media">
						<?php 
							if($db_found){
								$sqlObjetN = "SELECT * FROM produit WHERE MethodeVente LIKE 'Negoce' limit 1";
								$resultObjetN = mysqli_query($db_handle,$sqlObjetN) or die (mysqli_error($db_handle));
								while ($dataObjetN = mysqli_fetch_assoc($resultObjetN)) {
									echo '
										<a href="page_catalogue_client.php?categoriePrduit=2"><img class="mr-3" src="'.$dataObjetN["Photo1"].'" alt="ObjetN1"></a>
										
										<div class="media-body">
							
										<h5 class="mt-0 mb-1"><b>'.$dataObjetN["Nom"].'</b></h5>
											<p> '.$dataObjetN["DescriptionCourte"].'</p>
										</div>
									
									
									';
								}
							}
						?>
					</li>
				</ul>
			</div>
			
			
			<div class="information">
			<?php
			
				if ($db_found) {															
									$sqlNegoce = "SELECT * FROM produit WHERE Numero = '%$produitConnected%'";
									$resultNegoce = mysqli_query($db_handle, $sqlNegoce);
									
								if (mysqli_num_rows($resultNegoce) == 0)
								{
									echo "ERREUR : Créer une négociation";
								}
								else{
									while ($dataNegoce = mysqli_fetch_assoc($resultNegoce)) {
										echo '
				
				
									<div class="row">
										<div class="col-lg-6">
											<h3><b>'.$dataNegoce["Nom"].'</b></h3>
										</div>
										<div class="col-lg-6">
										<h3>'.$dataNegoce["Categorie"].'</h3>
										</div>
									
										<div class="col-lg-3" style="background-color:inherit"></div>
									</div>
				
									<div class="row">
										<div class="col-lg-3" id="ok">
											<a href="#"><img class="imageProduit center" src="'.$dataNegoce["Photo1"].'"></a>
										</div>
										<div class="col-lg-8" style="background-color:white">
											<h3>Description</h3>
												<p>'.$dataNegoce["DescriptionLongue1"].'</p>
										</div>
									</div>
									
									<div class="row">
										<br><p></p><br><br>
									</div>
									
									<div class="information_vendeur">							
										<div class="row">
											<div class="col-sm-2" style="background-color:inherit">
											</div>
													
											<div class="col">
												<a href="profil_vendeur_public_client.php?pseudoVendeur="Simon""><h3>Vendeur '.$dataNegoce["PseudoVendeur"].' </h3></a>									
											</div>																		
									</div>
												
							';
						}
					}
				}else{
					echo "Database not found";
				}		
				?>
			</div>
		
			<div class="row">
			
				<div class="col">
					<div class="col">
						
						
							<?php 
								if ($db_found) {
									$sqlOffresClient = "SELECT * FROM negociation WHERE (IDAcheteur like '%$idConnected%' AND NumeroProduit like '%$produitConnected%')";
									$resultOffresClient = mysqli_query($db_handle, $sqlOffresClient);
								if (mysqli_num_rows($resultOffresClient) == 0)
								{
									echo "ERREUR UNE";
								}
								else{
									while ($dataOffresClient = mysqli_fetch_assoc($resultOffresClient)) {
										echo '
										<div id="mesoffres">
											<h3>Mes offres : </h3> <?php echo "  $erreurOffre"; ?>
												<ul class="list-mesoffres">
													<li class="list-group-item" style="background-color:white" id="objetc1"> Offre 1 : '.$dataOffresClient["Prop2"].'</li>
													
													<li class="list-group-item" style="background-color:white" id="objetc2"> Offre 2 : '.$dataOffresClient["Prop4"].'</li>
													
													<li class="list-group-item" style="background-color:white" id="objetc3"> Offre 3 : '.$dataOffresClient["Prop6"].'</li>
													
													<li class="list-group-item" style="background-color:white" id="objetc4"> Offre 4 : '.$dataOffresClient["Prop8"].'</li>
													
													<li class="list-group-item" style="background-color:white" id="objetc5"> Offre 5 : '.$dataOffresClient["Prop10"].'</li>
												</ul>
										</div>
										';
									}
								}
							}else{
									echo "DATABASE NOT FOUND";
							}
						?>
							
					</div>
					<div class="col">
						
						<?php 
								if ($db_found) {
									$sqlOffresVendeur = "SELECT * FROM negociation WHERE (IDAcheteur like '%$idConnected%' AND NumeroProduit like '%$produitConnected%')";
									$resultOffresVendeur = mysqli_query($db_handle, $sqlOffresVendeur);
								if (mysqli_num_rows($resultOffresVendeur) == 0)
								{
									echo "ERREUR UNE";
								}
								else{
									while ($dataOffresVendeur = mysqli_fetch_assoc($resultOffresVendeur)) {
										echo '				
										<div id="offresvendeur">
						
											<h3>Offres du vendeurs : </h3>
												<ul class="list-offresvendeur">
													<li class="list-group-item" style="background-color:white" id="objetv1">Offre 1 : '.$dataOffresVendeur["Prop1"].'</li>
													
													<li class="list-group-item" style="background-color:white" id="objetv2">Offre 2 : '.$dataOffresVendeur["Prop3"].'</li>
													
													<li class="list-group-item" style="background-color:white" id="objetv3">Offre 3 : '.$dataOffresVendeur["Prop5"].'</li>
													
													<li class="list-group-item" style="background-color:white" id="objetv4">Offre 4 : '.$dataOffresVendeur["Prop7"].'</li>
													
													<li class="list-group-item" style="background-color:white" id="objetv5">Offre 5 : '.$dataOffresVendeur["Prop9"].'</li>
												</ul>
										</div>
									';
									}
								}
							}else{
									echo "DATABASE NOT FOUND";
							}
						?>				
					</div>
			
				</div>
				<div class="w-100"></div>
				<div id="accepter" style="display:none">
					<div class="col">
					<form action="negoce_client.php" method="post">
						<input type="submit" class="btn btn-success btn-block" id="accepterbutton" name="accepterbutton" value="Accepter l'offre">
					</form>
					</div>
				</div>
				<div id="accepterdisabled">
					<div class="col">
					<button class="btn btn-success btn-block" id="accepterdisabledbutton" disabled>Accepter l'offre</button>
					</div>
				</div>
				<div class="w-100"></div>
				<div class="col-lg-5" style="background-color:inherit"><p>  </p></div>
				<div class="w-100"></div>
				<div class="col">
					<div class="row">
						<form  action="negoce_client.php" method="post">
						<div class="col">
							<input type="submit" class="btn btn-primary" id="boutonoffre" name="boutonoffre" value="Proposer une nouvelle offre">
						</div>
						<div class="col">
							<input type ="text" class="form-control" id="nouvelleoffre" name="nouvelleoffre" placeholder="Saisir votre nouvelle offre">						
						</div>
						</form>
					</div>
				</div>
				<div class="col-lg-5" style="background-color:inherit"><p>  </p></div>
				<div class="col-lg-5" style="background-color:inherit"><p>  </p></div>
			<div class="w-100"></div>
				<div class="col">
					<a href="#"><button class="btn btn-danger btn-block">Arrêter la négociation</button></a>
				</div>
			<div class="w-100"></div>
				<div class="col">
				<h3>Règlement des négociations </h3>
				<p> Vous pouvez proposer 5 offres au vendeur. Le vendeur se garde le droit de mettre un terme à la négociation. Vous ne pouvez vous retracter après avoir proposer une offre. Aucun remboursement ne sera effectuer. </p>
				<form>
					<div class="form-group">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" id="gridCheck" onChange="afficheaccepter(gridCheck)">
							<label class="form-check-label" for="gridCheck">
									Je certifie avoir pris connaissance des conditions d'utilisations.
							</label>
						</div>
					</div>
				</form>		
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
