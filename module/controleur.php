<?php 

 require_once __DIR__.'/modele.php';
 require_once __DIR__.'/vue.php';

 class Controleur {

 	private $modele;
 	private $vue;

 	public function __construct() {
 		$this->modele = new Modele();
 		$this->vue = new Vue();
 	}

 	public function faireVerificationToken($tokenVerifier) {
 		$resultat = $this->modele->verificationToken($tokenVerifier);
 		return $resultat;
 	}

 	public function faireNouveauToken() {
 		$resultat = $this->modele->nouveauToken();
 		return $resultat;
 	}

 }

?>