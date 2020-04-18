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
 ?>

<!DOCTYPE html>
<html>
	<head>
		<title>Informations</title>
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
		<link rel="stylesheet" type="text/css" href="Styles/infos.css">
	</head>

	<body>	
	<!-- 00 -->
	<!-- TOP -->
	<!-- 00 -->
		
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
	
	<div class="container-fluid">
		<div>
			<h1 id="titrePrincipal" align="center"><strong>Informations</strong></h1>
		</div>
		<div class="row conteneurInfos">
			<div class="container-fluid">
				<h2 class="titreCategorie">Qui sommes nous ?</h2>
				<div class="row explications">
					Nous sommes une équipe d'étudiants de troisième année de l'ECE Paris-Lyon. Ebay-ECE a été créé à l'occasion d'un projet en format piscine pour le cours "Web Dynamique".<br>
				</div>
			</div>
		</div>
		<div class="row" id="espacement"></div>
		<div class="row conteneurInfos" style="margin-bottom: 80px;">
			<div class="container-fluid">
				<ul style="list-style: none;padding-left: 0px;">
					<li>
						<h2 class="titreCategorie">Comment fonctionne ce site ?</h2>
						<div class="row explications">
							Ebay-ECE est un site web pour la vente aux enchères pour la communauté ECE Paris. Le site permet à ses utilisateurs d'acheter, d'enchérir ou de négocier pour les produits vendus sur le site. Les vendeurs sont capable de vendre leurs produits sur le site en choisissant les méthodes de ventes.
						</div>
					</li>
					<br>
					<li>
						<h2 class="titreCategorie">Comment puis-je acheter des produits ?</h2>
						<div class="row explications">
							N'importe quel utilisateur connecté sur un compte client est capable d'acheter des produits de la manière qu'il le souhaite. Si vous n'avez pas de compte, vous pouvez en créer un gratuitement depuis la page de connexion.<br>Il n'est pas nécessaire d'être connecté pour pouvoir consulter le catalogue, mais il faut obligatoirement être connecté pour ajouter des produits à son panier ou pour s'engager dans un achat.
						</div>
					</li>
					<br>
					<li>
						<h2 class="titreCategorie">Quelles sont les différentes méthodes de ventes ?</h2>
						<div class="row explications">
							Il y a 3 méthodes de ventes possible :
							<ul>
								<li>
									L'achat direct est la méthode la plus classique : tous les produits sont disponibles à l'achat direct. Pour acheter un produit par cette méthode, il suffit de l'ajouter à son panier depuis la page de présentation de l'objet. Une fois tous les objets souhaités ajoutés au panier, vous pouvez cliquer sur l'icone "panier" dans la barre de navigation pour pouvoir consulter votre panier, éventuellement supprimer des objets de la liste, et le valider pour passer au paiement.
								</li>
								<li>
									La vente aux enchère peut être proposée par le vendeur s'il le souhaite. Celui-ci definira une date de fin d'enchère, jusqu'à laquelle chaque utilisateur a la possibilité de faire une unique offre du montant de son choix. Une fois la date limite atteinte, l'utilisateur qui aura fait l'offre la plus élevée est déclaré gagnant de l'enchère. Dans le cas où plusieurs utilisateurs feraient la même offre, seul le premier d'entre eux à effectuer l'offre en question sera déclaré gagnant. La somme à payer pour le gagnant sera la somme minimale, inférieure ou égale à la valeur de son offre, requise pour surpasser toutes les autres offres.
								</li>
								<li>
									La négociation peut être proposée par le vendeur s'il le souhaite. L'utilisateur choisissant cette méthode sera alors mis en contact avec le vendeur, à qui il pourra proposer une offre. Le vendeur a le choix d'accepter l'offre ou d'en proposer une autre à l'utilisateur. Il n'est possible pour l'utilisateur et le vendeur, pour une même négociation, que d'effectuer que 5 offres chacun. Si l'utilisateur refuse la cinquième offre du vendeur, la négociation prendra fin.
								</li>
							</ul>
							Si le vendeur choisit de mettre un produit eux enchères, il ne peut pas choisir de le proposer à la négociation, et vice-versa.
						</div>
					</li>
					<br>
					<li>
						<h2 class="titreCategorie">Puis-je décider de retirer une offre ?</h2>
						<div class="row explications">
							Non, il n'est pas possible pour l'utilisateur d'annuler une offre effectuée. Lorsque l'utilisateur effectue une offre, il s'engage à payer la somme concernée si l'offre venait à être acceptée.
						</div>
					</li>
					<br>
					<li>
						<h2 class="titreCategorie">Comment puis-je vendre mes produits ?</h2>
						<div class="row explications">
							Seuls les utilisateurs propriétaires d'un compte vendeur ont la capacité de vendre leur produits sur Ebay-ECE. Seul les administrateurs du site ont la possibilité d'ajouter des vendeurs. Pour obtenir votre propre compte vendeur, veuillez contacter un administrateur via les informations situées en pied de page.
						</div>
					</li>
				</ul>
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