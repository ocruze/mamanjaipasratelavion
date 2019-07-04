<?php

require_once __DIR__.'/../modele.php';

class ModeleInscription extends Modele {

	public function __construct() {
		parent::__construct();
	}

	public function inscription($idToken = null) {

		$email = htmlspecialchars($_POST['email']);
		$pseudo = htmlspecialchars($_POST['pseudo']);
		$motDePasseSimple = htmlspecialchars($_POST['motDePasse']);
		$motDePasseConfirmation = htmlspecialchars($_POST['motDePasseConfirmation']);

		$requete = self::$bdd->prepare('SELECT * FROM utilisateur WHERE email = :email OR pseudo = :pseudo');
		$requete->execute(array('email' => $email, 'pseudo' => $pseudo));
		$resultat = $requete->fetch();

		if ($resultat) {
			return 'Compte existant.';
		}

		if (!preg_match(self::$regexEmail, $email) || !(strlen($pseudo) > 3) || !preg_match(self::$regexMotDePasse, $motDePasseSimple) || $motDePasseSimple != $motDePasseConfirmation) {
			return 'Erreur de syntaxe.';
		}

		$motDePasse = password_hash($motDePasseSimple, PASSWORD_DEFAULT);

		$urlImageDefaut = 'image/profil/defaut.jpg';

		$requete = self::$bdd->prepare("INSERT INTO utilisateur VALUES(DEFAULT, :email, :pseudo, :motDePasse, :dateInscription, :dateDerniereConnexion, :image)");
		$requete->execute(array('email' => $email,'pseudo' => $pseudo, 'motDePasse' => $motDePasse, 'dateInscription' => date('Y-m-d H:i:s'), 'dateDerniereConnexion' => date('Y-m-d H:i:s'), 'image' => $urlImageDefaut));

		$requete = self::$bdd->prepare("SELECT * FROM utilisateur WHERE email = :email AND pseudo = :pseudo");
		$requete->execute(array('email' => $email, 'pseudo' => $pseudo));
		$resultat = $requete->fetch();
		$_SESSION['id'] = $resultat['idUtilisateur'];
		$_SESSION['pseudo'] = $resultat['pseudo'];
		$_SESSION['email'] = $resultat['email'];

		$this->supprimerToken($idToken);

		return '';

	}

}

?>