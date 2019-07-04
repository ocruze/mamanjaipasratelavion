<?php

if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
	header('Location: ./../');
	exit();
}

$titre = '404';
ob_start();

?>			<div class="error-bloc text-center main mx-auto fadeInLeftBig animated responsive">
				<div class="container">
					<h1>404 ! Oups, la page n'existe pas !</h1>
					<div class="error-container">
					  <span><span>4</span></span>
					  <span>0</span>
					  <span><span>4</span></span>
					</div>
				</div>
			</div>
<?php

$contenu = ob_get_clean();
require_once __DIR__.'/layout.php';

?>