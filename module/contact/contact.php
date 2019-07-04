<?php 

require_once __DIR__.'/controleurContact.php';

$controleur = new ControleurContact();

if (isset($_GET['action']) && htmlspecialchars($_GET['action']) == 'envoyer' && !empty($_POST)) {
	$controleur->faireEnvoyerMail();
} else {
	$controleur->faireAfficherFormulaire();
}

?>