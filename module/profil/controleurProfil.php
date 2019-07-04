<?php 

require_once __DIR__.'/../controleur.php';
require_once __DIR__.'/vueProfil.php';
require_once __DIR__.'/modeleProfil.php';

class ControleurProfil extends Controleur {

	private $modele;
	private $vue;

	public function __construct() {
		parent::__construct();
		$this->modele = new ModeleProfil();
		$this->vue = new VueProfil();
	}

	public function faireSupprimerCompte() {
		$this->modele->supprimerCompte();
		$this->faireDeconnexion();
	}

	public function faireAfficherProfil($resultat = null) {
		$donnees = $this->modele->getUtilisateurConnecte();
		$tokenPasse = $this->faireNouveauToken();
		$tokenPhoto = $this->faireNouveauToken();
		$this->vue->afficherProfil($donnees, $tokenPasse, $tokenPhoto, $resultat);
	}

	public function faireNouveauMotDePasse() {

		$tokenPasse = htmlspecialchars($_POST['tokenPasse']);

		$idToken = $this->faireVerificationToken($tokenPasse);

		if ($idToken) {
			$resultat = $this->modele->nouveauMotDePasse($idToken);
		} else {
			$resultat = 'Mauvais TOKEN.';
		}

		$this->vue->afficherResultatAJAX($resultat);

	}

	public function faireDeconnexion() {
		$this->modele->deconnexion();

		header("Location: ./");
	}

	public function faireChangerPhoto() {

		$tokenPhoto = htmlspecialchars($_POST['tokenPhoto']);

		$idToken = $this->faireVerificationToken($tokenPhoto);

		if ($idToken) {
			$resultat = $this->modele->changerPhoto($idToken);
		} else {
			$resultat = 'Mauvais TOKEN.';
		}

		$this->faireAfficherProfil($resultat);

	}

}

?>