						<script type="text/javascript" src="js/ajax.js"></script>
						<script type="text/javascript">
							function setpassword()
							{
								SuccessCallBack = function() { return; }
								var cp = document.getElementById("formcp").value;
								var np = document.getElementById("formnp").value;
								var cnp = document.getElementById("formcnp").value;
								var data = "mode=password&cp="+cp+"&np="+np+"&cnp="+cnp;

								AJAXOpen("{ADMINFOLDER}", data, SuccessCallBack);
							}
						</script>
						<div class="fadein"></div>
						<div class="post">
						<h2>Password Reset</h2>
						<div id="response"></div>
						<form>
							<p>Current Password:</p>
							<input id="formcp" type="password" size="65" value=""/>
							<p>New Password:</p>
							<input id="formnp" type="password" size="65" value=""/>
							<p>Confirm New Password:</p>
							<input id="formcnp" type="password" size="65" value=""/>
							<br /><br />
							<input type="submit" class="submit" onClick="setpassword(); return false;"/>
						</form>
						</div>
						<div class="fadeout"></div>
