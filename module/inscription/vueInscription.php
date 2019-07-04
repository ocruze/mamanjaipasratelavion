<?php
	
require_once __DIR__.'/../vue.php';
	
class VueInscription extends Vue {

	public function afficherPageInscription($token = null) { 	
		$titre = 'Inscription';
		ob_start();

?>

		<!-- SECTION -->
		<section>
			<div class="responsive compte main">
				<div class="container">
					<div class="petit-bloc mx-auto text-center fadeInLeftBig animated">
						<h1 class="text-primary">INSCRIPTION</h1>
						<div class="texte">
							<p class="text-secondary">Inscrivez-vous pour être un avion !</p>
						</div>
						<form method="post">
							<input type="hidden" name="token" value="<?php echo $token; ?>"/>
							<p><input type="text" name="pseudo" placeholder="Pseudo" data-toggle="tooltip" data-placement="right" title="Minimum 3 caractères."/>
							<input type="text" name="email" placeholder="Email" data-toggle="tooltip" data-placement="right" title="Exemple: dupont@dupont.fr" />
							<input type="password" name="motDePasse" placeholder="Mot de passe" data-toggle="tooltip" data-placement="right" title="8 caractères, 1 lettre et 1 chiffre."/>
							<input type="password" name="motDePasseConfirmation" placeholder="Confirmation" data-toggle="tooltip" data-placement="right" title="Confirmation de votre mot de passe."/> </p>
							<p><button class="btn btn-primary btn-inscription"><i class="fas fa-user-plus"></i>&nbsp;S'inscrire</button></p>
						</form>
						<a href="./?module=connexion">Déjà un compte ?</a>
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