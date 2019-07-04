<?php 

session_start(); 

if (isset($_GET['module'])) {

	$module = htmlspecialchars($_GET['module']);

	if ($module == 'connexion' || $module == 'inscription' || $module == 'profil' || $module == 'liste' || $module == 'contact' || $module == 'forum') {
		require_once __DIR__.'/module/'.$module.'/'.$module.'.php';
	} else {
		require_once __DIR__.'/template/404.php';
	}
	
} else {
	$titre = 'Accueil';
	ob_start();
	$_SESSION['current_page'] = $_SERVER['REQUEST_URI'];

?>			<div class="responsive index main">
				<div class="bloc-index mx-auto">
					<div class="container fadeInLeftBig animated text-center">
						<div class="titre-bloc-index">
							<img src="image/systeme/logo.png" alt="index"/>
						</div>
						<div class="choix-bloc-index">
							<form method="GET">
								<input type="hidden" name="module" value="liste"/>
								<div class="btn-group btn-group-toggle" data-toggle="buttons">
									<label class="btn btn-secondary active">
								    	<input type="radio" name="filtre" value="nom" checked="checked">Nom&nbsp;<i class="fas fa-sort-alpha-down"></i>
									</label>
								  	<label class="btn btn-secondary">
								    	<input type="radio" name="filtre" value="ville">Ville&nbsp;<i class="fas fa-city"></i>
									</label>
									<label class="btn btn-secondary">
								    	<input type="radio" name="filtre" value="pays">Pays&nbsp;<i class="fas fa-flag-usa"></i>
									</label>
								</div>
								<div class="saisie-bloc-index mx-auto">
									<input type="text" placeholder="Recherchez votre aéroport avec le filtre" name="saisie"/>
								</div>
								<div class="mx-auto">
									<p><button class="btn btn-secondary" type="submit">Rechercher&nbsp;<i class="fas fa-search"></i></button></p>
								</div>
							</form>
							<a href="?module=liste" class="btn btn-secondary">Voir tous les aéroports</a>
						</div>
					</div>
				</div>
			</div>
<?php 

	$contenu = ob_get_clean();
	require_once __DIR__.'/template/layout.php';

}

?>