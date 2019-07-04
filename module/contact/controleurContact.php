<?php 

require_once __DIR__.'/../controleur.php';
require_once __DIR__.'/modeleContact.php';
require_once __DIR__.'/vueContact.php';

class ControleurContact extends Controleur {

	private $modele;
	private $vue;

	public function __construct() {
		parent::__construct();
		$this->modele = new ModeleContact();
		$this->vue = new VueContact();
	}

	public function faireEnvoyerMail() {

		$token = htmlspecialchars($_POST['token']);

		$idToken = $this->faireVerificationToken($token);

		if ($idToken) {
			$resultat = $this->modele->envoyerMail($idToken);
		} else {
			$resultat = 'Mauvais TOKEN.';
		}

		$this->vue->afficherResultatAJAX($resultat);

	}

	public function faireAfficherFormulaire() {
		$token = $this->faireNouveauToken();
		$this->vue->afficherPage($token);
	}

}

?>