<?php 

require_once __DIR__.'/controleurForum.php';

$controleur = new ControleurForum();


if (isset($_GET['action']) && htmlspecialchars($_GET['action']) == 'thread' && isset($_GET['idPost'])) {
    /*empty($_POST) ? $controleur->faireAfficherThread(): $controleur->faireRepondreComm();*/
    if (empty($_POST)) {
    	$controleur->faireAfficherThread();
    }
    else if (isset($_POST['comm'])) {
    	$controleur->faireRepondreComm();
    }
    
}
else if (isset($_GET['action']) && htmlspecialchars($_GET['action']) == 'jaime' && isset($_GET['idPost'])) {

	$controleur->faireJaimePost(htmlspecialchars($_GET['idPost']));
	$controleur->faireAfficherThread();
}
else if(isset($_GET['module']) && htmlspecialchars($_GET['module']) == 'forum' && isset($_POST['contenuPost'])){
    	$controleur->faireOuvrirThread();
}
else {
    $controleur->faireAfficherListeThreads();
}

?>