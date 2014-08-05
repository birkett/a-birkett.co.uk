					<div class="middlec aero">
						<h2>Pages</h2>
						<?php
						$db = GetDatabase();
						$result = GetAllPages();
						while($row = $db->GetRow($result))
						{
							$id = $row[0];
							$title = $row[1];
							echo '<a href="'.ADMIN_FOLDER.'index.php?action=edit&pageid=' . $id . '"><p>' . $title . '</p></a>';
						}
						?>
					</div>
					<?php require_once("template/sidewidget.tpl"); ?>