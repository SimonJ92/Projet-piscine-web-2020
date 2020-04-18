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

    //Page
    $erreurIdentifiants = "";
    if ($idConnected!=0) {
        echo "erreur : vous êtes déjà connecté";
    }

    $ecranConnexion = 0;
    //0 = client
    //1 = vendeur

    if (isset($_POST["boutonConnexionClient"])) {
        if ($_POST["boutonConnexionClient"] && $ecranConnexion) {
            $ecranConnexion = 0;
        }
    }
    if (isset($_POST["boutonConnexionVendeur"])) {
        if ($_POST["boutonConnexionVendeur"] && !($ecranConnexion)) {
            $ecranConnexion = 1;
        }
    }
    if (isset($_POST["boutonConnexion"])) {
        if ($_POST["boutonConnexion"] && $db_found) {
            $ecranConnexion = isset($_POST["stateEcranConnexion"])?$_POST["stateEcranConnexion"]:0;
            $identifiantConnexion = isset($_POST["identifiantConnexion"])?$_POST["identifiantConnexion"]:"";
            $passwordConnexion = isset($_POST["motDePasse"])?$_POST["motDePasse"]:"";
            if($ecranConnexion == 0){   //tentative de connexion d'un client
                $sqlClient = "SELECT * from acheteur where AdresseMail like '%$identifiantConnexion%' and MotDePasse like '%$passwordConnexion%'";
                $resultConnexionClient = mysqli_query($db_handle,$sqlClient);
                if(mysqli_num_rows($resultConnexionClient) != 1){
                    $erreurIdentifiants = "L'identifant ou le mot de passe est erroné ";
                }elseif(mysqli_num_rows($resultConnexionClient) == 1){
                    $erreurIdentifiants = "";
                    $dataClient = mysqli_fetch_assoc($resultConnexionClient);
                    $_SESSION["typeConnected"] = 2;
                    $_SESSION["idConnected"] = $dataClient["IDAcheteur"];
                    header('Location: http://localhost/Projet-piscine-web-2020/Code/accueil_client.php');
                }
            }elseif ($ecranConnexion == 1) {    //tentative de connexion d'un vendeur
                $sqlVendeur = "SELECT * from vendeur where Pseudo like '%$identifiantConnexion%' and AdresseMail like '%$passwordConnexion%'";
                $resultConnexionVendeur = mysqli_query($db_handle,$sqlVendeur);
                if(mysqli_num_rows($resultConnexionVendeur) != 1){
                    $erreurIdentifiants = "L'identifant ou le mot de passe est erroné";
                }elseif(mysqli_num_rows($resultConnexionVendeur) == 1){
                    $erreurIdentifiants = "";
                }
            }else{
                echo "la variable 'ecranConnexion' est erronée";
            }
        }
    }
    

 ?>


<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <link rel="icon" href="Images/favicon.ico" type="images/x-icon">
        <title>Connexion</title>
        <link rel="stylesheet" href="Styles/page_de_connection_css/bootstrap.min.css">
        <!--<link rel="stylesheet" href="Styles/page_de_connection_fonts/font-awesome.min.css"> -->  <!--Ne change rien à la page-->
        <link rel="stylesheet" href="Styles/MyFooter.css">
        <link rel="stylesheet" href="Styles/page_de_connection_css/Login-Form-Clean.css">
        <link rel="stylesheet" href="Styles/nav_bar.css">
        <link rel="stylesheet" href="Styles/page_de_connection_css/styles.css">
    </head>

    <body>
    	<nav class="navbar navbar-expand-md" role="main" >
            <a class="navbar-brand" href="#" style="margin-right: 15%;">
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
                                <input type="submit" name="boutonCompte" value="Mon compte" class="btn btn-default" style="font-size: 1.5em;display:inline-block; margin-right: 10px;">
                                <input type="submit" name="toggleConnexion" value="Connexion" class="btn btn-danger" style="border: 1.5px solid black;display:inline-block;">
                        </div>
                        <div class="col-12 text-center">
                            <a class="nav-link" href="#">
                                <img style="max-width:100px;" src="Images/paniers.png" alt="">
                            </a>
                        </div>
                    </form>
                </div>

            </div>
        </nav>

        <div class="navbar sticky-top" role="sub" >
            <a href="#accueil">Accueil</a>
            <div class="subnav">
                <button class="subnavbtn">Catégories<i class="fa fa-caret-down"></i></button>
                <div class="subnav-content">
                    <a href="#ferrailles">Ferrailles ou Trésors</a>
                    <a href="#musee">Bon pour le Musée</a>
                    <a href="#vip">Accessoires VIP</a>  
                </div>
            </div>
            <div class="subnav">
                <button class="subnavbtn">Achats<i class="fa fa-caret-down"></i></button>
                <div class="subnav-content">
                    <a href="#encheres">Enchères</a>
                    <a href="#negociations">Négociations</a>
                </div>
            </div>              
        </div>


    	
    	<div class="login-clean" style="padding: 0px;">
            <!--<div style="height: 3px;background-color: #369fe0;"></div>      Cette barre n'est pas sur les autres pages, donc soit on la retire, soit on l'ajoute partout-->
            <div style="padding: 30px;" class="text-center"><?php echo $erreurIdentifiants; ?></div>
            <div class="container" style="width: 366px;height: 30px;padding: 0px;margin-bottom: 10px;">
                <form class="form-inline button-group-justified" style="padding: 0px;" action="page_de_connexion.php" method="post">

                    <?php echo '<input type="submit" name="boutonConnexionClient" value="Client" class="btn btn-success col-6 '.(($ecranConnexion)?'"':'active"').' style="border:1px solid;">'; ?>
                    <?php echo '<input type="submit" name="boutonConnexionVendeur" value="Vendeur" class="btn btn-success col-6 '.(($ecranConnexion)?'active"':'"').' style="border:1px solid;">'; ?>
                </form>
            </div>
            <div class="container" style="width: 346px;height: 603px;padding: 10px;background-color: #39dd99;">
                <form method="post" action="page_de_connexion.php" style="background-color: rgba(8,230,136,0.79);width: 326px;">
                    <h2 class="sr-only">Login Form</h2>
                    <div class="illustration"><img src="Images/page_de_connection_img/logo_v1_1.png"></div>
                    <div class="form-group">
                        <?php echo'<input class="form-control" type="'.(($ecranConnexion)?"text":"email").'" name="identifiantConnexion" placeholder="'.(($ecranConnexion)?"Pseudo":"Email").'">'; ?>
                    </div>
                    <div class="form-group">
                        <?php echo'<input class="form-control" type="'.(($ecranConnexion)?"email":"password").'" name="motDePasse" placeholder="'.(($ecranConnexion)?"E-mail":"Mot de passe").'">'; ?>
                    </div>
                    <a class="forgot" href="#" style="color: #3402ff;background-color: rgba(255,255,255,0);font-size: 14px;">Identifiant ou mot de passe oublié ?</a>
                    <div class="form-group">
                        <?php echo '<input type="hidden" name="stateEcranConnexion" value="'.$ecranConnexion.'">'; ?>
                        <input class="btn btn-primary btn-block" type="submit" style="background-color: #369fe0;" value="Connexion" name="boutonConnexion">
                    </div>
                    <a class="forgot" href="#" style="color: rgb(0,0,0);font-size: 14px;background-color: rgba(255,255,255,0);"></a>
                    <p class="text-center" style="font-size: 14px;color: rgb(0,0,0);">
                        Nouveau sur ECE-Ebay ?<a class="forgot" href="#" style="color: rgb(52,2,255);font-size: 14px;background-color: rgba(255,255,255,0);">Créez un compte<br></a>
                    </p>
                </form>
            </div>


            <div style="padding: 60px;"></div>  <!-- Cette div sert à quelquechose ? -->
        </div>




        <footer class="page-footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-12 text-center">
                        <h3>Page</h3>
                        <ul>
                            <li><a href="#">Accueil</a></li>
                            <li><a href="#">Mon compte</a></li>
                            <li><a href="#">Acheter</a></li>
                            <li><a href="#">Conditions d&#39;utilisation</a></li>
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
