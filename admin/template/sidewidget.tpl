					<div class="rightc aero">
					<?php
					if(isset($_SESSION['user']))
					{
						echo '<p>Logged in as ' . $_SESSION['user'] . ' <a href="'.ADMIN_FOLDER.'index.php?action=logout">(Logout)</a></p>';
					} 
					else 
					{
						echo '
						<form action="'.ADMIN_FOLDER.'index.php?action=login" method="POST">
							<input type="text" name="username" id="username"/>
							<input type="password" name="password" id="password"/>
							<input type="submit" name="Submit" id="submit"/>
						</form>';
					}
					?>
					</div>