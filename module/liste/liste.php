<?php

require_once __DIR__.'/controleurListe.php';

$controleur = new ControleurListe();

if (isset($_GET['action']) && htmlspecialchars($_GET['action']) == 'detail' && isset($_GET['id'])) {
    empty($_POST) ? $controleur->faireAfficherDetail() : $controleur->faireDonnerAvis();
} else if (/*isset($_GET['action']) && htmlspecialchars($_GET['action']) == 'supprimerAvis' && */!empty($_POST['id'])) { 
	$controleur->faireSupprimerAvis();
} else {
    $controleur->faireAfficherListe();
}

?>