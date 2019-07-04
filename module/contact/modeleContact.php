<?php

require_once __DIR__.'/../modele.php';

class ModeleContact extends Modele {

	public function __construct() {
		parent::__construct();
	}

	public function envoyerMail($idToken = null) {

		$sujet = htmlspecialchars($_POST['sujet']);
		$message = htmlspecialchars($_POST['message']);

		if (!empty($_SESSION['id'])) {
			$email = $_SESSION['email'];
			$pseudo = $_SESSION['pseudo'];
		} else {
			$email = htmlspecialchars($_POST['email']);
			$pseudo = htmlspecialchars($_POST['pseudo']);
		}

		if (!(strlen($sujet) > 1) || !(strlen($message) > 10) || (empty($_SESSION['id']) && (!preg_match(self::$regexEmail, $email) || !(strlen($pseudo) > 3)))) {
			return 'Syntaxe non conforme.';
		}

		$date = date('y-m-d');

		$texte = "$pseudo vous a envoyé un mail.\n\n";
		$texte .= "Son mail: $email\n\n";
		$texte .= "Son message: \"$message\"\n\n";
		$texte .= "Date: $date";

		$envoi = mail('fchen@iut.univ-paris8.fr', $sujet, $texte);

		if ($envoi) {
			$this->supprimerToken($idToken);
			return '';
		}

		return 'Erreur de serveur';

	}

}

?>