							<div class="fadein"></div>
							<div class="post">
								<a href="#"><h2 onClick="togglePosts(); return false;">All Posts &#x25BC;</h2></a>
								<div id="allposts">
								<ul>
									{MONTHLOOP}
									<li>
										<span><a href="#">{MONTH}</a></span>
										<ul>
											{ITEMLOOP}
											<li><a href="/blog/{POSTID}">{POSTTITLE}</a></li>
											{/ITEMLOOP}
										</ul>
									</li>
									{/MONTHLOOP}
								</ul>
								</div>
								<script src="js/postwidget.js"></script>
							</div>
							<div class="fadeout"></div>
