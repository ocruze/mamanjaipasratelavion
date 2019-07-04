<?php

if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
	header('Location: ./../');
	exit();
}

?>
<!DOCTYPE html>

<html lang="fr">
	<!-- HEAD -->
	<head>
			<title><?php echo $titre; ?></title>
			<meta charset="UTF-8"/>
			<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
			<script src="js/jquery-3.3.1.min.js"></script>
			<script src="js/popper.min.js"></script>
			<script src="js/bootstrap.min.js"></script>
			<script src="js/script.js"></script>
			<link rel="icon" href="image/systeme/icone.png"/>
			<link rel="stylesheet" href="css/style.css"/>
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


	</head>
	<!-- BODY -->
	<body>
		<!-- HEADER -->
		<header>
			<div class="responsive">
				<div class="menu navbar col-12 ">
					<div class="col-4">
						<a href="./"><strong><i class="far fa-paper-plane fa-lg"></i>&nbsp;Maman j'ai pas raté l'avion</strong>&nbsp;<i class="fas fa-signature fa-lg"></i></a>
					</div>
					<nav class="col-4">
						<a href="./"><i class="fas fa-home"></i>&nbsp;Accueil</a>
						<!-- <a href="?module=liste"><i class="far fa-list-alt"></i>&nbsp;Liste d'aéroports</a> -->
						<a href="?module=forum"><i class="fas fa-comments"></i>&nbsp;Forum</a>
						<a href="?module=contact"><i class="fas fa-phone"></i>&nbsp;Contact</a>
					</nav> 
					<div class="col-4 text-right">
<?php 			
						if (empty($_SESSION['id'])) {
?>
						<a href="?module=connexion"><i class="fas fa-sign-in-alt"></i>&nbsp;Connexion</a>&nbsp;|&nbsp;
						<a href="?module=inscription"><i class="fas fa-user-plus"></i>&nbsp;Inscription</a>
<?php 				
						} else {
?>
						<a href="?module=profil"><i class="fas fa-user"></i>&nbsp;Profil</a>&nbsp;|&nbsp;
						<a href="?module=profil&action=deconnexion"><i class="fas fa-sign-out-alt"></i>&nbsp;Déconnexion</a>
<?php 
						}
?>
					</div>
				</div>
			</div>
		</header>
		<!-- SECTION -->
		<section> 
<?php 
			echo $contenu;
?>
		</section>
		<!-- FOOTER -->
		<footer class ="footer">
			<div class="reseau-social text-center responsive">
				<div class="icone-reseau-social">
					<a href="https://www.facebook.com/" class="fab fa-facebook"></a>
					<a href="https://twitter.com/" class="fab fa-twitter"></a>
					<a href="https://www.instagram.com/" class="fab fa-instagram"></a>
				</div>
				<div class="texte-reseau-social">
					<span><i class="fas fa-globe"></i>&nbsp;Rejoignez-nous sur les réseaux sociaux !</span>
				</div>
			</div>
		</footer>
	</body>
</html>