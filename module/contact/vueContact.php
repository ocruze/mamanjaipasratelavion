<?php

require_once __DIR__.'/../vue.php';

class VueContact extends Vue {

	public function afficherPage($token = null) {
		$titre = 'Contact';
		
		ob_start();
		$_SESSION['current_page'] = $_SERVER['REQUEST_URI'];

?>			<div class="contact main responsive">
				<div class="petit-bloc mx-auto text-center fadeInLeftBig animated">
					<div class="container">
						<h1 class=text-primary>CONTACT</h1>
						<div class=texte>
							<p class="text-secondary">On ne va pas répondre de toute façon.</p>
						</div>
						<form method="post">
							<input type="hidden" name="token" value="<?php echo $token; ?>"/>
							<p><input type="text" name="sujet" placeholder="Sujet" data-toggle="tooltip" data-placement="right" title="Minimum 3 caractères."/>
<?php
							if (empty($_SESSION['id'])) {
?>
							<input type="text" name="pseudo" placeholder="Pseudo" data-toggle="tooltip" data-placement="right" title="Minimum 5 caractères."/>
							<input type="text" name="email" placeholder="Email" data-toggle="tooltip" data-placement="right" title="Exemple: dupont@test.fr"/>
<?php 						
							}
?>
							</p>
							<p><textarea name="message" class="form-control" rows="3" placeholder="Message" data-toggle="tooltip" data-placement="right" title="Minimum 10 caractères."></textarea></p>
							<p><button class="btn btn-primary btn-contact">Envoyer</button></p>
						</form>
					</div>
				</div>
			</div>
<?php 

		$contenu = ob_get_clean();
		require_once __DIR__.'/../../template/layout.php';

	}

}

?>