<?php

require_once __DIR__.'/../modele.php';

class ModeleConnexion extends Modele {

	public function __construct() {
		parent::__construct();
	}

	public function connexion($idToken = null) {

		$email = htmlspecialchars($_POST['email']);
		$motDePasse = htmlspecialchars($_POST['motDePasse']);

		$requete = self::$bdd->prepare('SELECT idUtilisateur, motDePasse, email, pseudo FROM utilisateur WHERE email = :email');
		$requete->execute(array('email' => $email));
		$resultat = $requete->fetch();

		if (!$resultat) {
			return 'Compte inexistant.';
		}

		$hashCorrect = password_verify($motDePasse, $resultat['motDePasse']);

		if (!$hashCorrect)  {
			return 'Mot de passe incorrect.';
		}

		$requete = self::$bdd->prepare('UPDATE utilisateur SET dateDerniereConnexion = :now WHERE idUtilisateur = :id AND email = :email AND pseudo = :pseudo');
		$requete->execute(array('email' => $email, 'id' => $resultat['idUtilisateur'], 'pseudo' => $resultat['pseudo'], 'now' => date('y-m-d')));

		$_SESSION['id'] = $resultat['idUtilisateur'];
		$_SESSION['pseudo'] = $resultat['pseudo'];
		$_SESSION['email'] = $resultat['email'];

		$this->supprimerToken($idToken);

		return '';
		
	}

	public function restaurerMotDePasse($idToken = null) {

		$email = htmlspecialchars($_POST['email']);

		$requete = self::$bdd->prepare('SELECT pseudo FROM utilisateur WHERE email = :email');
		$requete->execute(array('email' => $email));

		$resultat = $requete->fetch();

		if (!$resultat) {
			return 'Aucun mail trouvé.';
		}

		$motDePasse = $this->getRandom(16);
		$motDePasseCrypte = password_hash($motDePasse, PASSWORD_DEFAULT);

		$message = 'Votre nouveau mot de passe est: '.$motDePasse."\n\n";
		$message .= 'Nous vous conseillons de la changer rapidement depuis votre profil.'."\n\n";
		$message .= 'Date de demande: '.date('y-m-d');

		$envoi = mail($email, 'Nouveau mot de passe !', $message);

		if (!$envoi) {
			return 'Problème de messagerie.';
		}

		$requete = self::$bdd->prepare('UPDATE utilisateur SET motDePasse = :motDePasse WHERE email = :email AND pseudo = :pseudo');
		$requete->execute(array('motDePasse' => $motDePasseCrypte, 'email' => $email, 'pseudo' => $resultat['pseudo']));

		$this->supprimerToken($idToken);

		return '';

	}

}

?>