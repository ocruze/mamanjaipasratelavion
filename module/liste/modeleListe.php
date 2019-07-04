<?php

require_once __DIR__.'/../modele.php';

class ModeleListe extends Modele {

    public function __construct() {
        parent::__construct();
    }

	public function getListe() {
        $requete = self::$bdd->prepare("SELECT * from aeroport ORDER BY vue DESC");
        $requete->execute();
        $aeroport = $requete->fetchAll();
/*
        foreach ($aeroport as $value) {
            $requete = self::$bdd->prepare('SELECT * from avis where idAeroport = :idAeroport');
            $requete->execute(array('idAeroport' => $value['idAeroport']));
            $avis = $requete->fetchAll();

            $aeroport['noteGlobale'] = $this->moyenne($avis, 'noteGlobale');
        }*/

        /*die(var_dump($aeroport));*/



        return $aeroport;

        /*SELECT a.idAeroport, nomAeroport, villeAeroport, paysAeroport, photoBaseAeroport from aeroport a left join (SELECT idAeroport, noteGlobale from avis) as av on a.idAeroport = av.idAeroport ORDER BY vue DESC*/
    }

    public function getListeFiltree($filtre = array()) {

        if ($filtre['type'] != 'nom' && $filtre['type'] != 'ville' && $filtre['type'] != 'pays') {
            $this->getListe();
        } else {

            $type = $filtre['type'].'Aeroport';
            $requete = self::$bdd->prepare("SELECT * FROM aeroport WHERE LOWER($type) like :valeur ORDER BY vue DESC");
            $requete->execute(array('valeur' => '%'.$filtre['valeur'].'%'));
            $resultat = $requete->fetchAll();

            return $resultat;

        }

    }

	public function getDetail($id = 0) {
        $data = array();

        $requete = self::$bdd->prepare('SELECT * FROM aeroport where idAeroport = :id');
        $requete->execute(array('id' => $id));
        $resultat = $requete->fetch();
        $data['aeroport'] = $resultat;

        if ($resultat) {
            $requete = self::$bdd->prepare('UPDATE aeroport SET vue = vue + 1 WHERE idAeroport = :id');
            $requete->execute(array('id' => $id));
        }

        $requete = self::$bdd->prepare('SELECT a.idAeroport, idPhoto, cheminPhoto FROM aeroport a left join galerie g on a.idAeroport  = g.idAeroport where a.idAeroport = :id');
        $requete->execute(array('id' => $id));
        $resultat = $requete->fetchAll();
        $data['galerie'] = $resultat;

        /*var_dump($resultat);*/

        $requete = self::$bdd->prepare('SELECT a.idAvis, dateAvis, heureAvis, titreAvis, messageAvis, noteGlobale, borneEnreg, accesHandicape, a.idAeroport, a.idUtilisateur, tpsAttSecu, effPersSecu, hygieneGenerale, hygieneSanitaire, rpQuPrixRest, assezPlaceDispo, dutyFree, pseudo, dateInscription, dateDerniereConnexion, photoDeProfil FROM avis a left join utilisateur u on a.idUtilisateur = u.idUtilisateur where idAeroport = :id order by a.heureAvis desc, a.dateAvis desc');
        $requete->execute(array('id' => $id));
        $resultat = $requete->fetchAll();
        $data['avis'] = $resultat;

        $service = array();

        $service['borneEnreg']['0'] = "Borne d'enregistrement";
        $service['borneEnreg']['1'] = $this->estVrai($resultat, 'borneEnreg');
        
        $service['accesHandicape']['0'] = "Accès handicapé";
        $service['accesHandicape']['1'] = $this->estVrai($resultat, 'accesHandicape');
        
        $service['assezPlaceDispo']['0'] = "Assez de places assises disponibles";
        $service['assezPlaceDispo']['1'] = $this->estVrai($resultat, 'assezPlaceDispo');

        $service['noteGlobale']['0'] = "Note globale";
        /*$service['noteGlobale']['1'] = $this->moyenne($resultat, 'noteGlobale');*/
        $service['noteGlobale']['1'] = $data['aeroport']['noteGlobaleMoyenne'];

        $service['hygieneGenerale']['0'] = "Hygiène générale";
        $service['hygieneGenerale']['1'] = $this->moyenne($resultat, 'hygieneGenerale');

        $service['hygieneSanitaire']['0'] = "Hygiène sanitaire";
        $service['hygieneSanitaire']['1'] = $this->moyenne($resultat, 'hygieneSanitaire');

        $service['rpQuPrixRest']['0'] = "Rapport qualité prix de la restauration";
        $service['rpQuPrixRest']['1'] = $this->moyenne($resultat, 'rpQuPrixRest');

        $service['dutyFree']['0'] = "Les magasins \"Duty-free\" ";
        $service['dutyFree']['1'] = $this->moyenne($resultat, 'dutyFree');

        $service['tpsAttSecu']['0'] = "Temps d'attente pour la douane";
        $service['tpsAttSecu']['1'] = $this->moyenne($resultat, 'tpsAttSecu');

        $service['effPersSecu']['0'] = "Efficacité du personnel de la douane";
        $service['effPersSecu']['1'] = $this->moyenne($resultat, 'effPersSecu');

        $data['service'] = $service;

        /*echo $this->moyenne($resultat, 'tpsAttSecu');*/
        /*echo 4.8-intval(4.8);*/

        return $data;
    }

    public function estVrai($data, $s){
        $retour = 0;
        $ctr = 0;
        if (count($data) != 0) {

            foreach ($data as $value) {
                if ($value[$s] == 1) {
                    $ctr = $ctr + 1;
                }
            }
            
            if ($ctr/count($data) >= 0.75) {
                $retour = 1;
            }
        }
        return $retour;
                
    }

    public function moyenne($data, $s){
        $total = 0;
        $moyenne = 0;
        if (count($data) != 0) {
            foreach ($data as $value) {
                if ($value[$s] != 0) {
                    $total = $total + $value[$s];
                }
            }
            $moyenne = $total/count($data);
            if ($moyenne-intval($moyenne) > 0.5) {
                return intval($moyenne) + 1;
            }
            else {
                return intval($moyenne);
            }
        }
        else{
            return $moyenne;
        }
    }

    public function donnerAvis($data = array()) {

        $requete = self::$bdd->prepare('INSERT INTO avis values(DEFAULT, :idAeroport, :idUtilisateur, :dateAvis, :heureAvis, :titreAvis, :messageAvis, :noteGlobale, :borneEnreg, :accesHandicape, :tpsAttSecu, :effPersSecu, :hygieneGenerale, :hygieneSanitaire, :rpQuPrixRest, :assezPlaceDispo, :dutyFree)');
        
        $requete->execute(array('idAeroport' => $data['idAeroport'], 'idUtilisateur' => $_SESSION['id'], 'dateAvis' => date('y-m-d'), 'heureAvis' => date('h:i:s'), 'titreAvis' => $data['titreAvis'], 'messageAvis' => $data['messageAvis'], 'noteGlobale' => $data['noteGlobale'], 'borneEnreg' => $data['borneEnreg'], 'accesHandicape' => $data['accesHandicape'], 'tpsAttSecu' => $data['tpsAttSecu'], 'effPersSecu' => $data['effPersSecu'], 'hygieneGenerale' => $data['hygieneGenerale'], 'hygieneSanitaire' => $data['hygieneSanitaire'], 'rpQuPrixRest' => $data['rqQuPrixRest'], 'assezPlaceDispo' => $data['assezPlaceDispo'], 'dutyFree' => $data['dutyFree']));

        $requete = self::$bdd->prepare('SELECT * from avis where idAeroport = :idAeroport');
        $requete->execute(array('idAeroport' => $data['idAeroport']));
        $avis = $requete->fetchAll();

        $moyenne = $this->moyenne($avis, 'noteGlobale');

        $requete = self::$bdd->prepare('UPDATE aeroport set noteGlobaleMoyenne = :moyenne where idAeroport = :idAeroport');
        $requete->execute(array('moyenne' => $moyenne, 'idAeroport' => $data['idAeroport']));

    }

	public function supprimerAvis($id = 0) {
		if (!empty($_SESSION['id'])) {
			$requete = self::$bdd->prepare('SELECT idAvis, idAeroport FROM avis WHERE idAvis = :idAvis AND idUtilisateur = :idUtilisateur');
			$requete->execute(array('idAvis' => $id, 'idUtilisateur' => $_SESSION['id']));
			$resultat = $requete->fetch();
			if ($resultat) {
				$requete = self::$bdd->prepare('DELETE FROM avis WHERE idAvis = :id');
				$requete->execute(array('id' => $id));

                $requete = self::$bdd->prepare('SELECT * from avis where idAeroport = :idAeroport');
                $requete->execute(array('idAeroport' => $resultat['idAeroport']));
                $avis = $requete->fetchAll();

                $moyenne = $this->moyenne($avis, 'noteGlobale');

                $requete = self::$bdd->prepare('UPDATE aeroport set noteGlobaleMoyenne = :moyenne where idAeroport = :idAeroport');
                $requete->execute(array('moyenne' => $moyenne, 'idAeroport' => $resultat['idAeroport']));
			}
		}
	}


}

?>