<?php

require_once __DIR__.'/../controleur.php';
require_once __DIR__.'/modeleListe.php';
require_once __DIR__.'/vueListe.php';

class ControleurListe extends Controleur {

    private $modele;
    private $vue;

    public function __construct() {
        $this->modele = new ModeleListe();
        $this->vue = new VueListe();
    }

    public function faireAfficherDetail() {

        $id = htmlspecialchars($_GET['id']);
        $detail = $this->modele->getDetail($id);
        
        $this->vue->afficherDetail($detail);

    }

	public function faireSupprimerAvis() {
		$id = htmlspecialchars($_POST['id']);
        unset($_POST);
		$this->modele->supprimerAvis($id);
	}

    public function faireDonnerAvis() {

        $data = array();

        $data['idAeroport'] = htmlspecialchars($_POST['id']);
        $data['titreAvis'] = htmlspecialchars($_POST['titreAvis']);
        $data['messageAvis'] = htmlspecialchars($_POST['messageAvis']);
        $data['noteGlobale'] = htmlspecialchars($_POST['noteGlobale']);
        $data['borneEnreg'] = htmlspecialchars($_POST['borneEnreg']);
        $data['accesHandicape'] = htmlspecialchars($_POST['accesHandicape']);
        $data['tpsAttSecu'] = htmlspecialchars($_POST['tpsAttSecu']);
        $data['effPersSecu'] = htmlspecialchars($_POST['effPersSecu']);
        $data['hygieneGenerale'] = htmlspecialchars($_POST['hygieneGenerale']);
        $data['hygieneSanitaire'] = htmlspecialchars($_POST['hygieneSanitaire']);
        $data['rqQuPrixRest'] = htmlspecialchars($_POST['rqQuPrixRest']);
        $data['assezPlaceDispo'] = htmlspecialchars($_POST['assezPlaceDispo']);
        $data['dutyFree'] = htmlspecialchars($_POST['dutyFree']);

        unset($_POST);

        $resultat = $this->modele->donnerAvis($data);

        $this->faireAfficherDetail();

    }

    public function faireAfficherListe() {

        if (!empty($_GET['filtre']) && !empty($_GET['saisie'])) {

            $filtre = array();
            $filtre['type'] = strtolower(htmlspecialchars($_GET['filtre']));
            $filtre['valeur'] = strtolower(htmlspecialchars($_GET['saisie']));

            $liste = $this->modele->getListeFiltree($filtre);

        } else {
            $liste = $this->modele->getListe();
        }

        $this->vue->afficherListe($liste);

    }
}

?>