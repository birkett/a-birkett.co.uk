					<div class="rightc aero">
						<div class="widgetcontainer">
							<h2>All Blog Posts</h2>
							<?php
							$result = GetAllPosts();
							echo '<ul>';
							while($row = GetDatabase()->GetRow($result))
							{
								echo '<li><a href="/blog/' . $row[0] . '">' . $row[1] . '</a></li>';
							}
							echo '</ul>';
							?>
						</div>
					</div>
