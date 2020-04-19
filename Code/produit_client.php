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
    $numeroProduitPage = isset($_GET["numeroProduit"])?$_GET["numeroProduit"]:0;    //numero du produit concerné sur la page
    if ($numeroProduitPage == 0) {
        echo "Erreur : pas de produit spécifié";
    }elseif ($db_found) {
        $sqlProduitPage = "SELECT * from produit where Numero = ".$numeroProduitPage;
        $resultatProduitPage = mysqli_query($db_handle,$sqlProduitPage);
        if(mysqli_num_rows($resultatProduitPage) ==0){
            echo "Erreur : produit non trouvé dans la base de données";
        }else{
            $dataProduitPage = mysqli_fetch_assoc($resultatProduitPage);
            $pseudoVendeurProduit = $dataProduitPage["PseudoVendeur"];
            $sqlPhotosVendeur = "SELECT * from produit where PseudoVendeur like '$pseudoVendeurProduit' limit 3";
            $resultatPhotosVendeur = mysqli_query($db_handle,$sqlPhotosVendeur) or die (mysqli_error($db_handle));
            $countPhotos = 1;
            while ($dataPhotos = mysqli_fetch_assoc($resultatPhotosVendeur)) {
                $_SESSION["PhotoPageProduit".$countPhotos] = $dataPhotos["Photo1"];
                $countPhotos = $countPhotos +1;
            }
        }
    }

    if($db_found)
    {
        $_SESSION["numeroPhotoPageProduit"] = (isset($_SESSION["numeroPhotoPageProduit"]) && isset($dataProduitPage["Photo".(1 + $_SESSION["numeroPhotoPageProduit"])]))?$_SESSION["numeroPhotoPageProduit"]:1;
    }

    if($db_found && isset($_POST["boutonNextImage"])){
        if($_POST["boutonNextImage"] && isset($dataProduitPage["Photo".(1 + $_SESSION["numeroPhotoPageProduit"])])){
                $_SESSION["numeroPhotoPageProduit"] = $_SESSION["numeroPhotoPageProduit"] + 1;
        }
    }
    if($db_found && isset($_POST["boutonFormerImage"])){
        if($_POST["boutonFormerImage"] && $_SESSION["numeroPhotoPageProduit"]>1){
                $_SESSION["numeroPhotoPageProduit"] = (($_SESSION["numeroPhotoPageProduit"] -1));
        }
    }

    //achats
    if($db_found && isset($_POST["boutonPanier"])){
        if($_POST["boutonPanier"]){
            $sqlVerifPanier = "SELECT * from panier where NumeroProduit = $numeroProduitPage and IDClient = $idConnected";
            $resultTestPanier = mysqli_query($db_handle,$sqlVerifPanier) or die (mysqli_error($db_handle));
            if(mysqli_num_rows($resultTestPanier) != 0){
                echo "<script>alert(\"L'objet est déjà dans votre panier\")</script>";
            }else{
                $sqlAjouterPanier = "INSERT into panier (NumeroProduit, IDClient) values ('$numeroProduitPage','$idConnected')";
                $resulatInsertionPanier = mysqli_query($db_handle,$sqlAjouterPanier) or die (mysqli_error($db_handle));
            }
        }
    }
    if($db_found && isset($_POST["boutonEncheres"])){
        if($_POST["boutonEncheres"]){
            header('Location: enchere_client.php?numeroProduit='.$numeroProduitPage);
        }
    }
    if($db_found && isset($_POST["boutonNegoce"])){
        if($_POST["boutonNegoce"]){
            header('Location: negoce_client.php?numeroProduit='.$numeroProduitPage);
        }
    }
 ?>

<!DOCTYPE html>
<html>
	<head>
		<?php 
            echo '<title>'.$dataProduitPage["Nom"].'</title>';
         ?>
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
		<link rel="stylesheet" href="Styles/produit_client.css">
		<script src="Scripts/produit_client.js"></script>
		<!--<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">   faisait bugger la barre supérieure. La mise en commentaire ne semble pas changer la page ...-->
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
		<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

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


		<div class="wrapper">
        <div class="image">
            <?php echo '<img src="'.$dataProduitPage["Photo".$_SESSION["numeroPhotoPageProduit"]].'" style="max-width: 100%; max-height: 100%;">' ?>
        </div>
        <div class="descrip">
            <h2> <b><?php echo $dataProduitPage["Nom"]; ?></b> </h2>
            <p> <?php echo (isset($dataProduitPage["DescriptionCourte"])?$dataProduitPage["DescriptionCourte"]:""); ?> </p>
        </div>
        <div class="vendeur">
            <p>Vendeur : <?php echo $dataProduitPage["PseudoVendeur"]; ?> </p>
        </div>
        <div class="lienvendeur">
            <?php echo '<a href="profil_vendeur_public_'.(($typeConnected == 3)?"vendeur":"client").'.php?pseudoVendeur=&quot;'.$dataProduitPage["PseudoVendeur"].'&quot;">'; ?>
                <p>Voir le profil de <?php echo $dataProduitPage["PseudoVendeur"]; ?></p>
            </a>
        </div>
        
        <div class="changerImage">
            <?php echo '<form action="produit_client.php?numeroProduit='.$numeroProduitPage.'" method="post">' ?>
                <input type="submit" name="boutonFormerImage" class="btn btn-block btn-warning" value="Image Précédente"> <br><br>
                <input type="submit" name="boutonNextImage" class="btn btn-block btn-warning" value="Image Suivante"> <br><br>
            </form>
        </div>

        <?php 
            if ($typeConnected == 2) {
                echo '
                    <div class="option">
                        <!-- <p>Options d\'achat</p> -->
                        <form action="produit_client.php?numeroProduit='.$numeroProduitPage.'" method="post">
                            <div class="col text-center">
                                <input type="submit" name="boutonPanier" class="btn btn-block btn-primary" value="Ajouter au panier"> <br><br>
                                <input type="submit" name="boutonEncheres" class="btn btn-block btn-primary" value="Voir aux enchères"> <br><br>
                                <input type="submit" name="boutonNegoce" class="btn btn-block btn-primary" value="Négocier une meilleure offre"> <br><br>
                            </div>
                        </form>
                    </div>
                ';
            }
         ?>
        
        
        <?php 
            if ($typeConnected == 3 && $pseudoVendeurProduit == $pseudoConnected) {
                echo '
                    <div class="suppr"> 
                    <!-- Attention le client ne peut pas supprimer de produit -->
                        <!-- <p>Bouton pour supprimer le produit de la base de données</p> -->
                        <form action="produit_client.php?numeroProduit='.$numeroProduitPage.'" method="post">
                            <input type="submit" name="supprimerObjet" class="btn btn-sm btn-block btn-danger" onclick="validation()" value="Supprimer le produit de la vente">
                        </form>
                    </div>
                ';
            }
         ?>
        
        <div class="simili">
            <h3>Autres produits du vendeur</h3>
            <div class="row" align="center">
                <div class="col-4">
                    <div id="carrousel">
                    <ul>
                        <?php 
                            if($countPhotos > 1){echo '<li><img src="'.$_SESSION["PhotoPageProduit1"].'" style="max-width: 200px;max-height: 200px;"/></li>';}
                            if($countPhotos > 2){echo '<li><img src="'.$_SESSION["PhotoPageProduit2"].'" style="max-width: 200px;max-height: 200px;"/></li>';}
                            if($countPhotos > 3){echo '<li><img src="'.$_SESSION["PhotoPageProduit3"].'" style="max-width: 200px;max-height: 200px;"/></li>';}
                         ?>
                    </ul>
                    <br>
                    </div>
                </div>
                <div class="col-4">
                    <div id="carrousel2">
                    <ul>
                        <?php 
                            if($countPhotos > 2){echo '<li><img src="'.$_SESSION["PhotoPageProduit2"].'" style="max-width: 200px;max-height: 200px;"/></li>';}
                            if($countPhotos > 3){echo '<li><img src="'.$_SESSION["PhotoPageProduit3"].'" style="max-width: 200px;max-height: 200px;"/></li>';}
                            if($countPhotos > 1){echo '<li><img src="'.$_SESSION["PhotoPageProduit1"].'" style="max-width: 200px;max-height: 200px;"/></li>';}
                         ?>
                    </ul>
                    <br>
                    </div>
                </div>
                <div class="col-4">
                    <div id="carrousel3">
                    <ul>
                        <?php 
                            if($countPhotos > 3){echo '<li><img src="'.$_SESSION["PhotoPageProduit3"].'" style="max-width: 200px;max-height: 200px;"/></li>';}
                            if($countPhotos > 1){echo '<li><img src="'.$_SESSION["PhotoPageProduit1"].'" style="max-width: 200px;max-height: 200px;"/></li>';}
                            if($countPhotos > 2){echo '<li><img src="'.$_SESSION["PhotoPageProduit2"].'" style="max-width: 200px;max-height: 200px;"/></li>';}
                         ?>
                    </ul>
                    <br>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="fulldescrip">
            <p> <b>Description complète</b> : <br><?php echo (isset($dataProduitPage["DescriptionLongue1"])?$dataProduitPage["DescriptionLongue1"]:""); ?> <p>
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