				<script src="js/newcomment.js"></script>
				<div class="post aero commentbox">
					<h2>New comment</h2>
					<div id="response"></div>
					<form>
						<input id="formpostid" type="hidden" value="{POSTID}">
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