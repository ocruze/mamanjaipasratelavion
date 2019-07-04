<?php

require_once __DIR__.'/../controleur.php';
require_once __DIR__.'/modeleInscription.php';
require_once __DIR__.'/vueInscription.php';

class ControleurInscription extends Controleur {

	private $modele;
	private $vue;

	public function __construct() {
		parent::__construct();
		$this->modele = new ModeleInscription();
		$this->vue = new VueInscription();
	}

	public function faireAfficherPageInscription() {
		$token = $this->faireNouveauToken();
		$this->vue->afficherPageInscription($token);
	}

	public function faireInscription() {

		$token = htmlspecialchars($_POST['token']);

		$idToken = $this->faireVerificationToken($token);

		if ($idToken) {
			$resultat = $this->modele->inscription($idToken);
		} else {
			$resultat = 'Mauvais TOKEN.';
		}

		$this->vue->afficherResultatAJAX($resultat);

	}

}

?>