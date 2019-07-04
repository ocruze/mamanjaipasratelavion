<?php

require_once __DIR__.'/../modele.php';

class ModeleProfil extends Modele {

	public function getUtilisateurConnecte() {

		$requete = self::$bdd->prepare('SELECT * FROM utilisateur WHERE idUtilisateur = :id');
		$requete->execute(array('id' => $_SESSION['id']));
		$resultat = $requete->fetch();

		$donnees = array();
		$donnees['pseudo'] = $resultat['pseudo'];
		$donnees['email'] = $resultat['email'];
		$donnees['photo'] = $resultat['photoDeProfil'];
		$donnees['dateDerniereConnexion'] = $resultat['dateDerniereConnexion'];
		$donnees['dateInscription'] = $resultat['dateInscription'];

		return $donnees;

	}

	public function nouveauMotDePasse($idToken = null) {

		$motDePasse = htmlspecialchars($_POST['motDePasse']);

		if (!preg_match(self::$regexMotDePasse, $motDePasse)) {
			return 'Mot de passe non conforme.';
		} 

		$motDePasseCrypte = password_hash($motDePasse, PASSWORD_DEFAULT);

		$requete = self::$bdd->prepare('UPDATE utilisateur SET motDePasse = :motDePasse WHERE idUtilisateur = :id');
		$requete->execute(array('motDePasse' => $motDePasseCrypte, 'id' => $_SESSION['id']));

		$this->supprimerToken($idToken);

		return '';
		
	}

	public function supprimerCompte() {
		$requete = self::$bdd->prepare('DELETE FROM utilisateur WHERE idUtilisateur = :id');
		$requete->execute(array('id' => $_SESSION['id']));

		$requete = self::$bdd->prepare('DELETE FROM avis WHERE idUtilisateur = :id');
		$requete->execute(array('id' => $_SESSION['id']));

		$requete = self::$bdd->prepare('DELETE FROM forum WHERE idUtilisateur = :id');
		$requete->execute(array('id' => $_SESSION['id']));
	}

	public function changerPhoto($idToken = null) {

		$this->supprimerToken($idToken);

		$file = $_FILES['photoProfil'];
		$taille = getimagesize($file['tmp_name']);
		$extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

		if (($extension == 'png' || $extension == 'gif' || $extension == 'jpg' || $extension == 'jpeg') && $taille[0] < 800 && $taille[1] < 800) {
			$nomImage = $this->getRandom(8).'.'.$extension;
			$path = 'image/profil/'.$nomImage;
			$requete = self::$bdd->prepare('SELECT photoDeProfil FROM utilisateur WHERE idUtilisateur = :id');
			$requete->execute(array('id' => $_SESSION['id']));
			$resultat = $requete->fetchColumn();
			if(move_uploaded_file($file['tmp_name'], $path)) {
				if ($resultat != 'image/profil/default.jpg') {
					unlink($resultat);
				}
				$requete = self::$bdd->prepare('UPDATE utilisateur SET photoDeProfil = :photo WHERE idUtilisateur = :id');
				$requete->execute(array('photo' => $path, 'id' => $_SESSION['id']));
				return 'La modification a été un succès !';
			}

			return 'Erreur inconnue.';

		}

		return 'Taille ou extension incorrecte.';

	}

	public function deconnexion() {
    	unset($_SESSION['id']);
    	unset($_SESSION['pseudo']);
    	unset($_SESSION['email']);
	}

}

?>	