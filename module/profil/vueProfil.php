<?php 

require_once __DIR__.'/../vue.php';

class VueProfil extends Vue {

	public function afficherProfil($data = null, $tokenPasse = null, $tokenPhoto = null, $message = null) { 
		$titre = 'Profil';
		ob_start();

?>
			<div class="responsive compte main">
				<div class="container">
					<div class="petit-bloc mx-auto text-center fadeInDown animated">
						<h1 class="text-primary">PROFIL</h1>
						<div class="texte">
							<p class="text-secondary">Bienvenue <?php echo $data['pseudo']; ?> !</p>
						</div>
						<div class="col-12 mx-auto">
							<?php if (!is_null($message)) echo "<strong>$message</strong>\n"; ?>
							<p><img class="photo-profil" src="<?php echo $data['photo'] ?>"/></p>
							<form method="post" enctype="multipart/form-data">
								<input type="hidden" name="module" value="profil"/>
								<input type="hidden" name="tokenPhoto" value="<?php echo $tokenPhoto; ?>"/>
							    <strong>Changer de photo de profil ! Extension: jpg, jpeg, png et gif. Taille maximale: 500x500px.</strong>
							    <input type="file" name="photoProfil" data-toggle="tooltip" data-placement="top" title="Téléchargez votre photo.">
							    <input type="submit" value="Changer !">
							</form>
							<div class="text-secondary">
								<p>Pseudo: <?php echo $data['pseudo']; ?></p>
								<p>Email: <?php echo $data['email']; ?></p>
								<p>Mot de passe: <a data-toggle="modal" href=".changer"/>Changer mon mot de passe</a></p>
								<p>RGPD: <a class="btn-supprimer-compte" href="?module=profil&action=supprimer">Supprimer mon compte</a></p>
							</div>
						</div>
					</div>
				</div>
				<!-- MODAL -->
				<div class="responsive modal fade changer " role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title">Changer son mot de passe.</h4>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>
							<div class="modal-body">
								<form method="post">
									<input type="hidden" name="tokenPasse" value="<?php echo $tokenPasse; ?>"/>
									 <p><input type="password" name="nouveau-mot-de-passe" placeholder="Nouveau mot de passe" class="form-control" data-toggle="tooltip" data-placement="top" title="Minimum 8 caractères, 1 lettre et 1 chiffre."/></p>
									<p><input type="submit" class="btn btn-info btn-changer" value="Envoyer"/><p>
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
							</div>
						</div>
					</div>
				</div>	
			</div>
<?php 

		$contenu = ob_get_clean();
		require_once __DIR__.'/../../template/layout.php';

	}

}

?>