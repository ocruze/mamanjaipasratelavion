<?php

if (!empty($_SESSION['id'])) {
	header('Location: ?module=profil');
	exit();
}

require_once __DIR__.'/controleurInscription.php';
$controleur = new controleurInscription();

if (isset($_GET['action']) && htmlspecialchars($_GET['action']) == 'inscrire' && !empty($_POST)) {
	$controleur->faireInscription();
} else {
	$controleur->faireAfficherPageInscription();
}
	
?>