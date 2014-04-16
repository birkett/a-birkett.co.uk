					<div class="middlec aero">
						<h2>Posts</h2>
						<?php
						$db = GetDatabase();
						$result = GetAllPosts(true);
						while($row = $db->GetRow($result))
						{
							$id = $row[0];
							$title = $row[1];
							$draft = $row[2];
							$draft ? $draft = " (DRAFT)" : $draft = "";
							echo '<a href="'.ADMIN_FOLDER.'index.php?action=edit&postid=' . $id . '"><p>' . $title . $draft . '</p></a>';
						}
						?>
					</div>
					<?php require_once("template/sidewidget.tpl"); ?>