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
						<a class="left" href="{PAGEPREVLINK}">{PAGEPREVTEXT}</a>
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
							var data = "mode=postcomment&postid="+p+"&username="+u+"&comment="+c+"&response="+grecaptcha.getResponse();

							AJAXOpen("/", data, SuccessCallBack);
							grecaptcha.reset();
						}
					</script>
					<script src="https://www.google.com/recaptcha/api.js" async defer></script>
					<div class="fadein"></div>
					<div class="post commentbox">
						<h2>New comment</h2>
						<div id="response"></div>
						<form accept-charset="utf-8">
							<input id="formpostid" type="hidden" value="{COMMENTPOSTID}"/>
							<p>Your name (3 - 25 characters):</p>
							<input id="formusername" type="text" size="50"/>
							<p>Comment (10 - 1000 characters):</p>
							<textarea id="formcomment" rows="5" cols="40"></textarea>
							<p>Human verification:</p>
							<div class="g-recaptcha" data-sitekey="{RECAPTCHAKEY}"></div>
							<br /><br />
							<input type="submit" class="submit" onClick="newcomment(); return false;"/>
						</form>
					</div>
					<div class="fadeout"></div>
					{/NEWCOMMENT}
