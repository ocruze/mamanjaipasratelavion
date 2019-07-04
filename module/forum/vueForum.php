<?php  

require_once __DIR__.'/../vue.php';

class vueForum extends Vue{

	public function afficherListeThreads($data){
		$titre = 'Forum';
		ob_start();
		$_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
?>
	<!-- SECTION -->
	<section>
		<div class="modal fade ouvrir-thread" role="dialog">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Ouvrez un nouveau thread</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<form method="post" id="form-ouvrir-thread">
							<p><textarea name="sujetPost" placeholder="Le sujet de votre thread" class="form-control" data-toggle="tooltip" data-placement="top" data-original-title="Minimum 1 caractère."></textarea></p>
							<p><textarea name="contenuPost" placeholder="Expliquez votre thread en détail" class="form-control" data-toggle="tooltip" data-placement="top" data-original-title=""></textarea></p>
							<input type="submit" class="btn btn-success btn-poster" value="Soumettre"/>
							<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
						</form>
					</div>								
				</div>									
			</div>
		</div>

		<div class="main fadeInLeftBig animated forum">
			<div class="container">
				<div class="pb-3 d-inline-block col-12 bg-light">
					<div class="my-3 bg-light border rounded">
						<div class="row">
							<div class="col-sm text-center"><h1><strong>Bienvenue au forum !</strong></h1></div>
						</div>
					</div>
					<?php
				if (empty($_SESSION['id'])){
?>
					<div class="row text-center">
						<div class="col-sm">
							<a href="?module=connexion"><h3 class="btn btn-primary">Connectez-vous pour ouvrir ou répondre aux threads</h3></a>
						</div>
					</div>
<?php
				}
				else{
?>
					<div class="row text-center">
						<div class="col-sm">
							<div class=""><a class="btn btn-info btn-ouvrir-thread" data-toggle="modal" href=".ouvrir-thread">Ouvrir un nouveau thread</a></div>
						</div>
					</div>
<?php
				}
 $this->afficherListeThreadsOP($data); ?>


				</div>
			</div>
		</div>
	</section>
		


<?php
		$contenu = ob_get_clean();
    	require_once __DIR__.'/../../template/layout.php';
	}

	public function afficherListeThreadsOP($data){
		foreach ($data as $value) {
			if ($value['idPostParent'] == 0) {
				$this->afficherPost($value, null, 0);
			}
		}		
	}

	public function afficherPost($post, $postParent = null, $repondre = 1){
?>
		

		<div class="mx-2 p-2">
			<div class="row">
				<div class="col-sm"><a href="?module=forum&action=thread&idPost=<?php echo $post['idPost']; ?>"><h3> <?php echo $post['sujetPost']; ?> </h3></a></div>
			</div>
			<div class="row">
				<div class="col-sm-2 text-right mr-0">
					<img width="60px" height="60px" src="<?php echo $post['photoDeProfil']; ?>">
				</div>
				
				<div class="col-sm-10 ml-0">
					<div class="row">
<?php
						if ($postParent == null) {
?>
							<div class="col-sm"><h6>Posté par <?php echo $post['pseudo'].'#'.$post['idUtilisateur'].' le '. $post['datePost'].' à '. $post['heurePost']; ?> </h6></div>
<?php
						}
						else {
?>
							<div class="col-sm"><h6><?php echo $post['pseudo'].'#'.$post['idUtilisateur'] ?> <i class="fas fa-reply-all fa-flip-horizontal"></i> <?php echo $postParent['pseudo'].'#'.$postParent['idUtilisateur'].' le '. $post['datePost'].' à '. $post['heurePost']; ?> </h6></div>
<?php
						}
?>
						
					</div>
					<div class="row">
						<div class="col-sm"><h5><?php echo $post['contenuPost']; ?></h5></div>
					</div>
					<div class="row element-jaime">
						<div class="ml-3 text-left"><a class="btn-jaime" idJaime="<?php echo $post['idPost']; ?>" href="?module=forum&action=jaime&idPost=<?php echo $post['idPost']; ?>">J'aime</a></div>
<?php
						if ($repondre == 1) {
		 					if (!empty($_SESSION['id'])){
?>
								<div class="ml-4 text-left"><a class="btn-repondre" idPost="<?php echo $post['idPost']; ?>" data-toggle="modal" href=".repondre">Répondre</a></div>
<?php
							}
						}
?>
							
					
						<div class="ml-4 text-left">
							<div class="row">
								<div class="col-sm-2 text-left nb-jaime<?php echo $post['idPost']; ?>">
									<?php echo $post['jaime']; ?>									
								</div>
								<div class="col-sm-2 text-left">
										<i class="fas fa-thumbs-up"></i>
								</div>
							</div>
							
							
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	}

	public function afficherThread($data){
		$iOP;
		for ($i=0; $i < count($data); $i++) { 
			if ($data[$i]['idPostParent'] == 0 && $data[$i]['idPost'] == htmlspecialchars($_GET['idPost'])) {
				$iOP = $i;
			}
		}

		$titre = $data[$iOP]['sujetPost'];
		ob_start();
		$_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
?>

		<!-- SECTION -->
	<section>
		<div class="modal fade repondre" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Ecrivez ou répondez à un commentaire</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<form method="post" id="form-comment">
							<input type="hidden" name="idPostParent" value="">
							<p><textarea name="comm" placeholder="Votre commentaire" class="form-control" data-toggle="tooltip" data-placement="top" data-original-title="Minimum 1 caractère."></textarea></p>
							<input type="submit" class="btn btn-success btn-repondre" value="Soumettre"/>
							<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
						</form>
					</div>								
				</div>									
			</div>
		</div>

		<div class="main fadeInLeftBig animated forum ">
			<div class="container bg-light mt-2 border rounded">				
				<div class="row py-1 px-3">
					<?php $this->afficherPost($data[$iOP]); ?>
				</div>
<?php
				if (empty($_SESSION['id'])){
?>
					<div class="row text-center">
						<div class="col-sm">
							<a href="?module=connexion"><h3 class="btn btn-primary">Connectez-vous pour répondre à ce thread</h3></a>
						</div>
					</div>
<?php
				}
				

				/*commentaires commencent ici*/
				foreach ($data as $comm) {
					if ($comm['idPostParent'] == $data[$iOP]['idPost']) {
?>
						<div class="comm">
<?php
							$this->afficherPost($comm, $data[$iOP]);
							foreach ($data as $sousComm) {
								if ($sousComm['idPostParent'] == $comm['idPost']) {
?>
									<div class="comm">
<?php
										$this->afficherPost($sousComm, $comm);
										foreach ($data as $sousSousComm) {
											if ($sousSousComm['idPostParent'] == $sousComm['idPost']) {
?>
												<div class="comm">
													<?php $this->afficherPost($sousSousComm, $sousComm, 0); ?>
												</div>
<?php
											}											
										}
?>

									</div>
<?php
								}
							}
?>
						</div>
<?php
					}
				}
?>
			</div>
		</div>
	</section>
<?php
		$contenu = ob_get_clean();
    	require_once __DIR__.'/../../template/layout.php';
	}
}

?>