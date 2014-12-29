					<div class="rightc aero">
						<div class="widgetcontainer">
							<h2>All Blog Posts</h2>
							<?php
							$result = GetPosts("all", 0, false);
							$last_month = NULL;
							echo '<ul>';
							while($row = GetDatabase()->GetRow($result))
							{
								$month = date("F Y", $row[1]);
								if($month != $last_month)
								{
									if($last_month != NULL)
									{
										echo '</ul></li>';
									}
									$last_month = $month;
									echo '<li><span>' . $month . '</span><ul>';
								}
								echo '<li><span><a href="/blog/' . $row[0] . '">' . $row[2] . '</a></span></li>';
							}
							echo '</ul></li></ul>';
							?>
						</div>
					</div>
					<script src="js/postwidget.js"></script>
