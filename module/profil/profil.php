<?php

if (empty($_SESSION['id'])) {
	header('Location: ?module=connexion');
	exit();
}

require_once __DIR__.'/controleurProfil.php';
$controleur = new controleurProfil();

if (isset($_GET['action']) && htmlspecialchars($_GET['action']) == 'supprimer') {
	$controleur->faireSupprimerCompte();
} else if (isset($_GET['action']) && htmlspecialchars($_GET['action']) == 'changer' && isset($_POST['motDePasse'])) {
	$controleur->faireNouveauMotDePasse();
} else if (isset($_GET['action']) && htmlspecialchars($_GET['action']) == 'deconnexion') { 
	$controleur->faireDeconnexion();
} else if (!empty($_FILES['photoProfil']['name'])) {
	$controleur->faireChangerPhoto();
} else {
	$controleur->faireAfficherProfil();
}

?>