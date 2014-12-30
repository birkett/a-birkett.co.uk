							<h2>All Blog Posts</h2>
							<ul>
								{MONTHLOOP}
								<li>
									<span>{MONTH}</span>
									<ul>
										{ITEMLOOP}
										<li><span><a href="/blog/{POSTID}">{POSTTITLE}</a></span></li>
										{/ITEMLOOP}
										{ITEMS}
									</ul>
								</li>
								{/MONTHLOOP}
								{MONTHS}
							</ul>
							<script src="js/postwidget.js"></script>
