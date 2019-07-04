<?php

class Modele {

	protected static $bdd;
	protected static $regexMotDePasse;
	protected static $regexEmail;
	protected static $passage;

	public function __construct() {
		if (is_null(self::$bdd)) {
			self::initialisation();
		}
	}

	public function getRandom($longueur) {
		$randomKey = openssl_random_pseudo_bytes($longueur);
		$random = bin2hex($randomKey);
		return $random;
	}

	public function triggerToken() {
		$requete = self::$bdd->prepare('DELETE FROM token WHERE dateExpiration < NOW()');
		$requete->execute();
	}

	public function verificationToken($token) {

		$this->triggerToken();

		$requete = self::$bdd->prepare('SELECT idToken FROM token WHERE valeurToken = :token');
		$requete->execute(array('token' => $token));
		$resultat = $requete->fetchColumn();

		return $resultat;

	}

	public function supprimerToken($idToken) {
		$this->triggerToken();
		$requete = self::$bdd->prepare('DELETE FROM token WHERE idToken = :id');
		$requete->execute(array('id' => $idToken));
	}

	public function nouveauToken() {

		$this->triggerToken();

		$token = $this->getRandom(32);

		$requete = self::$bdd->prepare('INSERT INTO token VALUES(DEFAULT, :token, NOW() + INTERVAL 1 DAY)');
		$requete->execute(array('token' => $token));

		return $token;

	}

	protected static function initialisation() {

		self::$regexMotDePasse = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/';
		self::$regexEmail = '/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/';	

		$dsn = 'mysql:host=localhost;dbname=dutinfopw201624;charset=utf8';
		$user = 'root';
		$password = '';

//		$user = 'dutinfopw201624';
//		$password = 'syhatahu';

		try {
			self::$bdd = new PDO($dsn,$user,$password);
		} catch (PDOException $e) {
			require_once __DIR__.'/../template/maintenance.php';
			exit();
		}

	}

}

?>