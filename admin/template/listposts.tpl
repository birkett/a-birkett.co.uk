					<div class="middlec aero">
						<h2>Posts</h2>
						<?php
						$db = GetDatabase();
						$result = GetPosts("all", 0, true);
						while($row = $db->GetRow($result))
						{
							list($id, $timestamp, $title, $content, $draft) = $row;
							$draft ? $draft = " (DRAFT)" : $draft = "";
							echo '<a href="'.ADMIN_FOLDER.'index.php?action=edit&postid=' . $id . '"><p>' . $title . $draft . '</p></a>';
						}
						?>
					</div>
					<?php require_once("template/sidewidget.tpl"); ?>