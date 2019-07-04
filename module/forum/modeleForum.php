<?php 

require_once __DIR__.'/../modele.php';

class ModeleForum extends Modele{

	public function __construct() {
        parent::__construct();
    }

    public function getListeThreads(){

    	$requete = self::$bdd->prepare("SELECT * FROM forum natural join (select idUtilisateur, pseudo, photoDeProfil from utilisateur) as util ORDER BY datePost DESC, heurePost desc");
    	$requete->execute();
    	$resultat = $requete->fetchAll();

    	return $resultat;
    }

    public function getThread($id){
    	$requete = self::$bdd->prepare("SELECT * FROM forum natural join (select idUtilisateur, pseudo, photoDeProfil from utilisateur) as util where idPost = $id or idPostParent = $id ORDER BY forum.datePost ASC, forum.heurePost ASC");
    	$requete->execute();
    	$resultat = $requete->fetchAll();

    	return $resultat;
    }

    public function jaimePost($id){
    	$requete = self::$bdd->prepare("UPDATE forum SET jaime = jaime + 1 WHERE idPost = $id");
    	$requete->execute();

    }

    public function repondreComm($data){
		$changed = str_replace(' ', '', $data['contenuPost']);
        if ($changed != "" ) {
            $requete = self::$bdd->prepare("INSERT INTO forum VALUES(DEFAULT, :idPostParent, :idUtilisateur, :datePost, :heurePost, NULL, :contenuPost, 0)");

            $requete->execute(array('idPostParent' => $data['idPostParent'], 'idUtilisateur' => $data['idUtilisateur'],'datePost' => $data['datePost'], 'heurePost'=> $data['heurePost'], 'contenuPost' => $data['contenuPost']));
        }

    }

    public function ouvrirThread($data){
        $changed = str_replace(' ', '', $data['sujetPost']);
        if ($changed != "") {
            $requete = self::$bdd->prepare("INSERT INTO forum VALUES(DEFAULT, 0, :idUtilisateur, :datePost, :heurePost, :sujetPost, :contenuPost, 0)");

             $requete->execute(array('idUtilisateur' => $data['idUtilisateur'],'datePost' => $data['datePost'], 'heurePost'=> $data['heurePost'], 'sujetPost' => $data['sujetPost'], 'contenuPost' => $data['contenuPost']));
        }
    }

}

?>