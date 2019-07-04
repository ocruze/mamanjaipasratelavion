<?php

require_once __DIR__.'/../vue.php';

class VueConnexion extends Vue {

	public function afficherPageConnexion($tokenConnexion = null, $tokenOublier = null) {
		$titre = 'Connexion';
		ob_start();
?>
		
		<!-- SECTION -->
		<section>
			<div class="responsive compte main">
				<div class="container">
					<div class="petit-bloc mx-auto text-center fadeInLeftBig animated"> 
						<h1 class="text-primary">CONNEXION</h1>
						<div class="texte">
							<p class="text-secondary">Connectez-vous pour plus de savoir !</p>
						</div>
						<form method="post">
							<input type="hidden" name="tokenConnexion" value="<?php echo $tokenConnexion; ?>"/>
							<p><input type="text" name="email" placeholder="Email" data-toggle="tooltip" data-placement="right" title="Exemple: dupont@test.fr"/>
							<input type="password" name="motDePasse" placeholder="Mot de passe" data-toggle="tooltip" data-placement="right" title="Minimum 8 caractères, 1 lettre et 1 chiffre."/></p>
							<p><button class="btn btn-primary btn-connexion">Se connecter</button></p>
						</form>
						<p><a data-toggle="modal" href=".restaurer">J'ai oublié mon code secret.</a></p>
						<p class="text-right"><a href="./?module=inscription">Pas de compte ?</a></p>
					</div>
				</div>
				<!-- MODAL -->
				<div class="modal fade restaurer" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title">Réinitialiser son mot de passe.</h4>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>
							<div class="modal-body">
								<form method="post">
									<input type="hidden" name="tokenOublier" value="<?php echo $tokenOublier; ?>" />
									<p><input class="form-control" type="text" name="email-restaurer" placeholder="Email" data-toggle="tooltip" data-placement="right" title="Exemple : dupont@mail.fr"/></p>
									<p><input type="submit" class="btn btn-info btn-restaurer" value="Envoyer"/></p>
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
							</div>
						</div>
					</div>
				</div>	
			</div>
		</section>
<?php 
		
		$contenu = ob_get_clean();
		require_once __DIR__.'/../../template/layout.php';

	}

}

?>