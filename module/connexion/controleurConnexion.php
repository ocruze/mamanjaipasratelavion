<?php

require_once __DIR__.'/../controleur.php';
require_once __DIR__.'/vueConnexion.php';
require_once __DIR__.'/modeleConnexion.php';

class ControleurConnexion extends Controleur {

	private $modele;
	private $vue;

	public function __construct() {
		parent::__construct();
		$this->modele = new ModeleConnexion();
		$this->vue = new VueConnexion();
	}

	public function faireConnexion() {

		$tokenConnexion = htmlspecialchars($_POST['tokenConnexion']);

		$idToken = $this->faireVerificationToken($tokenConnexion);

		if ($idToken) {
			$resultat = $this->modele->connexion($idToken);
		} else {
			$resultat = 'Mauvais TOKEN.';
		}

		$this->vue->afficherResultatAJAX($resultat);

	}

	public function faireAfficherPageConnexion() {
		$tokenConnexion = $this->faireNouveauToken();
		$tokenOublier = $this->faireNouveauToken();
		$this->vue->afficherPageConnexion($tokenConnexion, $tokenOublier);
	}

	public function vouloirRestaurerMotDePasse() {

		$tokenOublier = htmlspecialchars($_POST['tokenOublier']);

		$idToken = $this->faireVerificationToken($tokenOublier);

		if ($idToken) {
			$resultat = $this->modele->restaurerMotDePasse($idToken);
		} else {
			$resultat = 'Mauvais TOKEN.';
		}

		$this->vue->afficherResultatAJAX($resultat);
		
	}

}

?>