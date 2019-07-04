<?php

if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
	header('Location: ./../');
	exit();
}

$titre = 'Maintenance';
ob_start();

?>			<div class="error-bloc text-center main mx-auto fadeInLeftBig animated responsive">
				<div class="container">
					<h1>Maintenance ! Oups, il parait que le site est en maintenance !</h1>
					<div class="error-container">
					  <span><span>Main</span></span>
					  <span>te</span>
					  <span><span>nance</span></span>
					</div>
				</div>
			</div>
<?php

$contenu = ob_get_clean();
require_once __DIR__.'/layout.php';

?>