							<h2>All Blog Posts</h2>
							<ul>
								{MONTHLOOP}
								<li>
									<span>{MONTH}</span>
									<ul>
										{ITEMLOOP}
										<li><span><a href="/blog/{POSTID}">{POSTTITLE}</a></span></li>
										{/ITEMLOOP}
									</ul>
								</li>
								{/MONTHLOOP}
							</ul>
							<script src="js/postwidget.js"></script>
