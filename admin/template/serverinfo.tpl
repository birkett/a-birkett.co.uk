					<div class="middlec aero">
						<h2>Server Information</h2>
						<?php
						echo 'Apache version: ' . $_SERVER["SERVER_SOFTWARE"] . '<br />';
						echo 'PHP version: ' . phpversion() . '<br />';
						echo 'MySQL server version: ' . GetDatabase()->ServerInfo() . '<br />';
						?>
					</div>
					<?php require_once("template/sidewidget.tpl"); ?>