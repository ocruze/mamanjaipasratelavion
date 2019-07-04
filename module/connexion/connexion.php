<?php

if (!empty($_SESSION['id'])) {
	/*header('Location: ?module=profil');*/
	/*echo $_SESSION['current_page'];*/
	header("Location: ". $_SESSION['current_page']);
	exit();
}

require_once __DIR__.'/controleurConnexion.php';
$controleur = new ControleurConnexion();

if (isset($_GET['action']) && htmlspecialchars($_GET['action']) == 'restaurer' && isset($_POST['email'])) {
	$controleur->vouloirRestaurerMotDePasse();
} else if (isset($_GET['action']) && htmlspecialchars($_GET['action']) == 'connecter' && isset($_POST['email']) && isset($_POST['motDePasse'])) {
	$controleur->faireConnexion();
} else {
	$controleur->faireAfficherPageConnexion();
}
	
?>