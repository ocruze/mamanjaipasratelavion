<?php  

require_once __DIR__.'/../controleur.php';
require_once __DIR__.'/modeleForum.php';
require_once __DIR__.'/vueForum.php';

class ControleurForum extends Controleur{

	private $modele;
    private $vue;

    public function __construct() {
        $this->modele = new ModeleForum();
        $this->vue = new VueForum();
    }

    public function faireAfficherListeThreads(){
    	$data = $this->modele->getListeThreads();
    	$this->vue->afficherListeThreads($data);
    }

    public function faireAfficherThread(){
        /*$id = htmlspecialchars($_GET['idPost']);*/
        /*$thread = $this->modele->getThread($id);*/
        $thread = $this->modele->getListeThreads();
        $this->vue->afficherThread($thread);
    }

    public function faireJaimePost($id){
        $this->modele->jaimePost($id);
        /*$_SESSION['current_page'] = $_SERVER['REQUEST_URI'];*/
        /*header("Location: ". $_SESSION['current_page']);*/
    }

    public function faireRepondreComm(){
        $data = array();
        foreach ($_POST as $key => $value) {
            $data['idPostParent'] = htmlspecialchars($value);
            break;
        }
        $data['idUtilisateur'] = htmlspecialchars($_SESSION['id']);
        $data['datePost'] = date('y-m-d');
        $data['heurePost'] = date('h:i:s');
        $data['contenuPost'] = htmlspecialchars($_POST['comm']);

        $this->modele->repondreComm($data);
        $this->faireAfficherThread();
    }

    public function faireOuvrirThread(){
        $data['idUtilisateur'] = htmlspecialchars($_SESSION['id']);
        $data['datePost'] = date('y-m-d');
        $data['heurePost'] = date('h:i:s');
        $data['sujetPost'] = htmlspecialchars($_POST['sujetPost']);
        $data['contenuPost'] = htmlspecialchars($_POST['contenuPost']);

        $this->modele->ouvrirThread($data);
        $this->faireAfficherListeThreads();
    }

}

?>