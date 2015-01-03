					{BLOGPOST}
					<div class="fadein"></div>
					<div class="post">
						<div class="postavatar">
							<img src="img/avatar.png" alt="avatar"/>
						</div>
						<a href="/blog/{POSTID}"><h2>{POSTTITLE}</h2></a>
						<p class="timestamp">{POSTTIMESTAMP}</p>
						{POSTCONTENT}
						<a class="right" href="/blog/{POSTID}">Comments({COMMENTCOUNT})</a>
					</div>
					<div class="fadeout"></div>
					{/BLOGPOST}
					
					{COMMENT}
					<div class="fadein"></div>
					<div class="post">
						<p class="timestamp">Posted by {COMMENTAUTHOR} on {COMMENTTIMESTAMP}</p>
						<p>{COMMENTCONTENT}</p>
					</div>
					<div class="fadeout"></div>
					{/COMMENT}
					
					{PAGINATION}
					<div class="fadein"></div>
					<div class="post commentbox">
						<a class="left" href="{PAGEPREVIOUSLINK}">{PAGEPREVIOUSTEXT}</a>
						<a class="right" href="{PAGENEXTLINK}">{PAGENEXTTEXT}</a>
					</div>
					<div class="fadeout"></div>
					{/PAGINATION}
					
					{NEWCOMMENT}
					<script type="text/javascript" src="js/ajax.js"></script>
					<script type="text/javascript">
						function newcomment()
						{
							SuccessCallBack = function()
							{
								document.getElementById("formusername").value="";
								document.getElementById("formcomment").value="";
							}
							
							var p = document.getElementById("formpostid").value;
							var u = document.getElementById("formusername").value;
							var c = document.getElementById("formcomment").value;
							var data = "mode=postcomment&postid="+p+"&username="+u+"&comment="+c+"&challenge="+Recaptcha.get_challenge()+"&response="+Recaptcha.get_response();

							AJAXOpen("/", data, SuccessCallBack);
							Recaptcha.reload();
						}
					</script>
					<div class="fadein"></div>
					<div class="post commentbox">
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
						<a href="" onClick="newcomment(); return false;">Submit</a>
						<br /><br />
					</div>
					<div class="fadeout"></div>
					{/NEWCOMMENT}
