					{BLOGPOST}
					<div class="postavatar">
						<img src="img/avatar.png" alt="avatar"/>
					</div>
					<div class="post aero">
						<p class="timestamp">{POSTTIMESTAMP}</p>
						<a href="/blog/{POSTID}"><h2>{POSTTITLE}</h2></a>
						{POSTCONTENT}
						<a class="right" href="/blog/{POSTID}">Comments({COMMENTCOUNT})</a>
					</div>
					{/BLOGPOST}
					{BLOGPOSTS}
					
					{COMMENT}
					<div class="post aero">
						<p class="timestamp">Posted by {COMMENTAUTHOR} on {COMMENTTIMESTAMP}</p>
						<p>{COMMENTCONTENT}</p>
						<div class="divider"></div>
					</div>
					{/COMMENT}
					{COMMENTS}
					
					{PAGINATION}
					<div class="post aero commentbox">
						<a class="left" href="{PAGEPREVIOUSLINK}">{PAGEPREVIOUSTEXT}</a>
						<a class="right" href="{PAGENEXTLINK}">{PAGENEXTTEXT}</a>
					</div>
					{/PAGINATION}
					
					{NEWCOMMENT}
					<script src="js/newcomment.js"></script>
					<div class="post aero commentbox">
						<h2>New comment</h2>
						<div id="response"></div>
						<form>
							<input id="formpostid" type="hidden" value="{COMMENTPOSTID}">
							<p>Your name (3 - 20 characters):</p>
							<input id="formusername" type="text" size="50">
							<p>Comment (10 - 500 characters):</p>
							<textarea id="formcomment" rows="5" cols="40"></textarea>
						</form>
						<p>Verification:</p>
						<script type="text/javascript">var RecaptchaOptions = { theme : "blackglass" };</script>
						<script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k={RECAPTCHAKEY}"></script><br />
						<a href="" onClick="postcomment(); return false;">Submit</a>
						<br /><br />
					</div>
					{/NEWCOMMENT}
