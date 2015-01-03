							<a href="#"><h2 onClick="toggleposts(); return false;">All Posts &#x25BC;</h2></a>
							<div id="allposts">
							<ul>
								{MONTHLOOP}
								<li>
									<span><a href="#">{MONTH}</a></span>
									<ul>
										{ITEMLOOP}
										<li><span><a href="/blog/{POSTID}">{POSTTITLE}</a></span></li>
										{/ITEMLOOP}
									</ul>
								</li>
								{/MONTHLOOP}
							</ul>
							</div>
							<script src="js/postwidget.js"></script>
