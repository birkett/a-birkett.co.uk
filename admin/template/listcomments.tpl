					<div class="middlec aero">
						<h2>Comments</h2>
						<table><tr><th>Comment</th><th>Username</th><th>Timestamp</th><th>Client IP</th></tr>
						<?php
						$db = GetDatabase();
						if(isset($_GET['ip']))
						{
							$result = GetAllComments($_GET['ip']);
						} 
						else
						{
							$result = GetAllComments();
						}
						while($row = $db->GetRow($result))
						{
							$id = $row[0];
							$postid = $row[1];
							$username = $row[2];
							$comment = $row[3];
							$timestamp = $row[4];
							$ip = $row[5];

							$link = '<a href="../blog/' . $postid . '"><p>' . $comment . '</p></a>';
							$filter = '<a href="'.ADMIN_FOLDER.'index.php?action=listcomments&ip='.$ip.'">'.$ip.'</a>';
							
							echo '<tr><td>' . $link . '</td><td>' . $username . '</td><td>' . date(DATE_FORMAT, $timestamp) . '</td><td>' . $filter . '</td></tr>';
						}
						?>
						</table>
					</div>
					<?php require_once("template/sidewidget.tpl"); ?>
