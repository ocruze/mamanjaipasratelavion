<?php
require_once __DIR__.'/../vue.php';

class VueListe extends Vue {

	public function afficherCarteAeroport($aeroport){
?>
		<div class="row bg-light py-1 border rounded col-sm">
			<div class="col-sm-2 my-auto liste-aeroport-img text-center">
				<img src="image/aeroport/<?php echo $aeroport['photoBaseAeroport']; ?>"/>
			</div>
			<div class="col-sm-6 my-auto text-justify">
				<h4><?php echo $aeroport['nomAeroport']; ?></h4>
			</div>
			<div class="col-sm-4 text-center">
				<div class="row lien-decoration-none">
					<h5 class="col-sm"><a href="./?module=liste&filtre=ville&saisie=<?php echo $aeroport['villeAeroport'] ?>"><?php echo $aeroport['villeAeroport'] ?></a> - <a href="./?module=liste&filtre=pays&saisie=<?php echo $aeroport['paysAeroport'] ?>"><?php echo $aeroport['paysAeroport'] ?></a></h5>
				</div>
				<div class="row text-center mx-auto">
					<a class="btn btn-secondary col-sm-12" href="./?module=liste&action=detail&id=<?php echo $aeroport['idAeroport']; ?>"><h5 >Consulter</h5></a>
				</div>
				<div class="row">
					<div class="col-sm mt-2">
						<?php $this->afficherEtoiles($aeroport['noteGlobaleMoyenne']); ?>
					</div>
				</div>
			</div>
		</div>
<?php
	}

	public function afficherListe($data) { 
        $titre = 'Liste';
		ob_start();
		$_SESSION['current_page'] = $_SERVER['REQUEST_URI'];

?>
		<section>
			<div class="main fadeInLeftBig animated responsive">
				<div class="container">
<?php
					if (count($data) > 0) {
?>
						<div class="row bg-light my-2 py-2 border rounded col-sm">
							<div class="col-sm text-center">
								<h5 class="my-auto">L'aéroport le plus consulté</h5>
							</div>
						</div>
						<?php $this->afficherCarteAeroport($data['0']); ?>
						<div class="row bg-light my-2 py-2 border rounded col-sm">
							<div class="col-sm text-center">
								<h5 class="my-auto">Les résultats de votre recherche</h5>
							</div>
						</div>
						<div class="row">
							<div class="col-sm scrollable-liste">
<?php
								foreach ($data as $value) {
									$this->afficherCarteAeroport($value);
								}

?>
							</div>
						</div>
<?php
					}
					else{
?>
						<div class="text-center error-bloc">
							<h2 class="text-black">Nous n'avons rien trouvé pour votre recherche. Veuillez réessayer.</h2>
							<h4 class="text-black">Vérifiez si vous avez choisi le bon filtre.</h4>
							<div class="error-container">
								<span><span>Nul</span></span>
								<span>à</span>
								<span><span>chier</span></span>
							</div>
						</div>
<?php
					}
?>
				</div>
			</div>
		</section>

<?php
		$contenu = ob_get_clean();
		require_once __DIR__.'/../../template/layout.php';
    }

    

    public function afficherEtoiles($nbEtoiles, $taille = "fa-lg"){
		for ($i=0; $i < $nbEtoiles; $i++) { 
?>
			<span class="fas fa-star <?php echo $taille; ?> checked"></span>
<?php
}
		for ($i=0; $i < 5 - $nbEtoiles; $i++) { 
?>
			<span class="fas fa-star <?php echo $taille; ?>"></span>
<?php
}
    }
    public function afficherServicesEtoiles($service){
?>
			<div class="row">
				<div class="col-sm-8 text-left">
					<h5><?php echo $service['0']; ?></h5>
				</div>
				<div class="col-sm-4 text-right">
					<?php $this->afficherEtoiles($service['1'], "fa-sm") ?>
				</div>
			</div>
<?php
    }
    public function afficherServicesOuiNon($service){
?>
			<div class="row">
				<div class="col-sm-10 text-left">
					<h5><?php echo $service['0'];  ?></h5>
				</div>
				<div class="col-sm-2 text-right">
<?php
		if ($service['1'] == 1) {
?>
				<i class="fas fa-check-circle fa-lg"></i>
<?php
		}
		else{
?>
				<i class="fas fa-times-circle fa-lg"></i>
<?php
		}
?>							
				</div>
			</div>
<?php
    }
    public function afficherDetail($data) {
    	$titre = 'Détail';
    	$aeroport = $data['aeroport'];
    	$avis = $data['avis'];
    	$galerie = $data['galerie'];
    	$service = $data['service'];
    	ob_start();
    	$_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
?>
		<div class="responsive">
    		<div class="main container mt-2">
    			<div class="p-4 border rounded border-white bg-light">
	    			<div>
		    			<div class="row">
		    				<div class="col-sm-8 text-left">
		    					<h1 class="d-inline-block"><?php echo $aeroport['nomAeroport'] ; ?></h1>
		    					<h3 class="d-inline-block"><?php echo " (" . $aeroport['codeAITA'] . "/" . $aeroport['codeOACI'] . ")" ; ?></h3>
		    				</div>
		    				<div class="col-sm-4 text-right mt-1">
		    					<?php $this->afficherEtoiles($service['noteGlobale']['1'], "fa-2x"); ?>
		    				</div>
		    			</div>
		    			<div class="row">
		    				<div class="col-sm">
								<h2><?php echo $aeroport['villeAeroport'] . ", " . $aeroport['paysAeroport']; ?></h2>
							</div>
						</div>
	    			</div>
<?php 		if (!empty($_SESSION['id'])) { ?>
			<!-- MODAL -->
    		<div class="modal fade donnerAvis" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Partagez votre avis !</h4>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
							<form method="post" id="form-avis">
								<input type="hidden" name="id" value="<?php echo $aeroport['idAeroport'] ?>"/>
								<div class="row">
									<div class="col-10 mb-2">
										<span>Comment a été votre expérience globale dans cet aéroport ?</span>
									</div>
									<div class="col-2 mb-2">
										<select name="noteGlobale">
											<option value="1" selected>1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
										</select>
									</div>
									<div class="col-10 mb-2">
										<span>Y'avait-il des bornes d'enregistrement sur place ?</span>
									</div>
									<div class="col-2 mb-2">
										<label>Oui</label>&nbsp;<input type="radio" name="borneEnreg" value="1" checked/>
										<label>Non</label>&nbsp;<input type="radio" name="borneEnreg" value="2"/>
									</div>
									<div class="col-10 mb-2">
										<span>Y'avait-il des accès handicapés ?</span>
									</div>
									<div class="col-2 mb-2">
										<label>Oui</label>&nbsp;<input type="radio" name="accesHandicape" value="1" checked/>
										<label>Non</label>&nbsp;<input type="radio" name="accesHandicape" value="2"/>
									</div>
									<div class="col-10 mb-2">
										<span>Combien de temps avez-vous pris pour passer la sécurité/douane ?</span>
									</div>
									<div class="col-2 mb-2">
										<input name="tpsAttSecu" class="saisie-douane" value="0"/>
									</div>
									<div class="col-10 mb-2">
										<span>Quelle note donneriez-vous au personnel de la sécurité/douane ?</span>
									</div>
									<div class="col-2 mb-2">
										<select name="effPersSecu">
											<option value="1" selected>1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
										</select>
									</div>
									<div class="col-10 mb-2">
										<span>Quelle note donneriez-vous pour l'hygiène générale de l'aéroport ?</span>
									</div>
									<div class="col-2 mb-2">
										<select name="hygieneGenerale">
											<option value="1" selected>1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
										</select>
									</div>
									<div class="col-10 mb-2">
										<span>Quelle note donneriez-vous pour l'hygiène sanitaire de l'aéroport ?</span>
									</div>
									<div class="col-2 mb-2">
										<select name="hygieneSanitaire">
											<option value="1" selected>1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
										</select>
									</div>
									<div class="col-10 mb-2">
										<span>Quelle note mettriez-vous au service de restauration pour son prix (s'il existe) ?</span>
									</div>
									<div class="col-2 mb-2">
										<select name="rqQuPrixRest">
											<option value="1" selected>1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
										</select>
									</div>
									<div class="col-10 mb-2">
										<span>Aviez-vous de la place pour vous poser ?</span>
									</div>
									<div class="col-2 mb-2">
										<label>Oui</label>&nbsp;<input type="radio" name="assezPlaceDispo" value="1" checked/>
										<label>Non</label>&nbsp;<input type="radio" name="assezPlaceDispo" value="0"/>
									</div>
									<div class="col-10 mb-2">
										<span>Quelle note donneriez-vous aux magasins "Duty-Free" (s'ils existent) ?</span>
									</div>
									<div class="col-2 mb-2">
										<select name="dutyFree">
											<option value="1" selected>1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
										</select>
									</div>
									<div class="col-12 mb-2">
										<p><strong>Nous vous invitons à laisser un avis pour décrire votre expérience globale.</strong></p>
									</div>
									<div class="col-12 mb-2">
										<p><input name="titreAvis" placeholder="Titre" class="form-control" data-toggle="tooltip" data-placement="top" data-original-title="Minimum 3 caractères."/></p>
										<p><textarea name="messageAvis" placeholder="Message" class="form-control" data-toggle="tooltip" data-placement="top" data-original-title="Minimum 10 caractères."></textarea></p>
									</div>
								</div>
								<p><input type="submit" class="btn btn-secondary btn-donnerAvis" value="Soumettre"/></p>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
						</div>
					</div>
				</div>
			</div>	
<?php 		}	?>	    		
	    		<div class="row">
	    			<div class="col-sm">
	    				<div id="carouselExampleIndicators" class="carousel slide " data-ride="carousel">
	    				
	    				<ol class="carousel-indicators">
						    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
						    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
						    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
						   	<li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
						   	<li data-target="#carouselExampleIndicators" data-slide-to="4"></li>

						</ol>
	    				<div class="carousel-inner text-center">
		    				<div id="photo_base" class="carousel-item">
		    					<img class="detail-photo" class="d-block w-100" src="image/aeroport/<?php echo $aeroport['photoBaseAeroport']; ?>"/>
		    				</div>
	    						<div class="carousel-item active">
<?php if ($galerie['0']['cheminPhoto'] != ""){ ?>
	    							<img class="img-thumbnail detail-photo" class="d-block w-100" src="image/aeroport/<?php echo $galerie['0']['cheminPhoto']; ?>"/>
<?php } else { ?>
									<img class="img-thumbnail detail-photo" src="image/aeroport/<?php echo $aeroport['photoBaseAeroport']; ?>"/>
<?php } ?>
	    						</div>
	    						<div class="carousel-item">
<?php if (count($galerie) > 1 && $galerie['1']['cheminPhoto'] != null){ ?>
	    							<img class="img-thumbnail detail-photo" class="d-block w-100" src="image/aeroport/<?php echo $galerie['1']['cheminPhoto']; ?>"/>
<?php } else { ?>
									<img class="img-thumbnail detail-photo" src="image/aeroport/<?php echo $aeroport['photoBaseAeroport']; ?>"/>
<?php } ?>
	    						</div>
	    						<div class="carousel-item">
<?php if (count($galerie) > 2 && $galerie['2']['cheminPhoto'] != null){ ?>
	    							<img class="img-thumbnail detail-photo" class="d-block w-100" src="image/aeroport/<?php echo $galerie['2']['cheminPhoto']; ?>"/>
<?php } else { ?>
									<img class="img-thumbnail detail-photo" src="image/aeroport/<?php echo $aeroport['photoBaseAeroport']; ?>"/>
<?php } ?>
	    						</div>
	    						<div class="carousel-item">
<?php if (count($galerie) > 3 && $galerie['3']['cheminPhoto'] != null){ ?>
	    							<img class="img-thumbnail detail-photo" class="d-block w-100" src="image/aeroport/<?php echo $galerie['3']['cheminPhoto']; ?>"/>
<?php } else { ?>
									<img class="img-thumbnail detail-photo" src="image/aeroport/<?php echo $aeroport['photoBaseAeroport']; ?>"/>
<?php } ?>
	    						</div>
	    					</div>
	    					
	    						
	    					
	    					<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
							    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
							    <span class="sr-only">Previous</span>
							  </a>
							  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
							    <span class="carousel-control-next-icon" aria-hidden="true"></span>
							    <span class="sr-only">Next</span>
							  </a>
	    			</div>
	    			</div>
	    			

	    			<div class="col-sm text-center p-2 ">
						<div class="row">
							<div class="col-sm">
								<h3>Les avis de nos utilisateurs sur cet aéroport</h3>
							</div>
						</div>
<?php  
$this->afficherServicesEtoiles($service['hygieneGenerale']);
$this->afficherServicesEtoiles($service['hygieneSanitaire']);
?>
<?php
$this->afficherServicesEtoiles($service['effPersSecu']);
$this->afficherServicesEtoiles($service['rpQuPrixRest']);
$this->afficherServicesEtoiles($service['dutyFree']);
?>	
						<div class="row">
							<div class="col-sm-8 text-left">
								<h5><?php echo $service['tpsAttSecu']['0']; ?></h5>
							</div>
							<div class="col-sm-4 text-right">
								<h5><?php echo $service['tpsAttSecu']['1'] . " minutes"; ?></h5>
							</div>
						</div>
	    		</div>
	    	</div>
    		<div class="mt-3">
    			<div class="row">
					<div class="col-sm text-center p-2 ">
						<h3>Trouvez votre itinéraire</h3>
							<iframe 
								width="330" 
  								height="170" 
								frameborder="0" 
								marginheight="0" 
								marginwidth="0" 
								src="https://maps.google.com/maps?q=+<?php echo $aeroport['latitude']; ?>+,+<?php echo $aeroport['longitude']; ?>+&hl=es;z=14&amp;output=embed"
							 >
							 </iframe>
							 <p><i>Cliquez sur la carte pour trouver votre itinéraire</i></p>
					</div>
					
					<div class="col-sm text-center p-2">
						<div class="row">
							<div class="col-sm">
								<h3>Services</h3>
							</div>
						</div>
<?php  
$this->afficherServicesOuiNon($service['borneEnreg']);
$this->afficherServicesOuiNon($service['accesHandicape']);
$this->afficherServicesOuiNon($service['assezPlaceDispo']);
?>
						<div class="btn_avis">
							<?php 	if (!empty($_SESSION['id'])) { ?>
										<a data-toggle="modal" href=".donnerAvis" class="btn btn-secondary">Donner votre avis !</a>
						<?php       } else echo '<strong>Connectez-vous pour donner un avis !</strong>'; ?>
						</div>

					</div>
					</div>
	
				</div>
			</div>

		
			<div class="pt-3">
				<div class="col-sm p-2 border rounded border-white bg-light text-center">
					<h2>Message des visiteurs</h2>

				</div>

<?php $this->afficherLesAvis($avis); ?>

			</div>
		
    	</div>
		</div>

<?php   
    	$contenu = ob_get_clean();
    	require_once __DIR__.'/../../template/layout.php';
	}
	public function afficherLesAvis($avis){
		echo "<div class=\"bloc-avis\">";
		foreach ($avis as $value) {
			if ($value['messageAvis'] == "") $value['messageAvis'] = 'Aucun commentaire';
?>
				<div class="row mt-2 pt-1 border rounded border-white comment" id="<?php echo $value['idAvis']; ?>">
					<div class="col-sm-2 my-auto text-center">
						<div>
							<img class="comment-photo-profil" src="<?php echo $value['photoDeProfil']; ?>">
							<h6><?php echo $value['pseudo']; ?></h6>
						</div>
					</div>
					<div class="col-sm-10 text-center">
						<div>
							<div class="row">
								<div class="col-sm-8 text-left">
									<h4><?php echo $value['titreAvis']; ?></h4>
								</div>
								<div class="col-sm-4 text-right">
<?php
$this->afficherEtoiles($value['noteGlobale']);
?>

							
								</div>
							</div>
							<div class="row">
								<div class="col-sm text-justify">
									<p><?php echo $value['messageAvis']; ?></p>
								</div>
							</div>
							<div class="row">
								<div class="col-sm text-justify d-inline-block">
									<h6>Le <?php echo $value['dateAvis'] . ' à ' . $value['heureAvis']; ?></h6>
								</div>
								<div class="col-sm float-right text-right">
<?php 
									if (!empty($_SESSION['id']) && $_SESSION['id'] == $value['idUtilisateur']) {
?>
									<a href class="btn-supprimer-avis" id="<?php echo $value['idAvis']; ?>">Supprimer</a>
<?php								}
?>
								</div>
							</div>
						</div>
					</div>
				</div>


<?php
			
		}
		echo "</div>";
	}
}
?>