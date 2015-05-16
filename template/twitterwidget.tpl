							<a target="_blank" title="Twitter" href="https://www.twitter.com/{TWITTERUSER}">
								<div class="headernavicon headertwittericon"></div>
							</a>
							<div class="tweets">
							{TWEETLOOP}
								<div class="tweet">
									<img src="{TWEETAVATAR}" alt="avatar" />
									<a target="_blank" href="https://www.twitter.com/{TWEETSCREENNAME}">{TWEETNAME} @{TWEETSCREENNAME}</a><br />
									{TWEETTEXT}
									<a target="_blank" href="https://www.twitter.com/{TWEETSCREENNAME}/status/{TWEETID}">{TWEETTIMESTAMP}</a>
								</div>
							{/TWEETLOOP}
							</div>
