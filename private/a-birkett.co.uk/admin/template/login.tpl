						<script type="text/javascript" src="/js/ajax.js"></script>
						<script type="text/javascript">
						function login()
						{
							SuccessCallBack = function() { location.reload(); }
							var username = document.getElementById("username").value;
							var password = document.getElementById("password").value;
							var data = "mode=login&username="+username+"&password="+password;

							AJAXOpen("/{ADMINFOLDER}index.php?page=login", data, SuccessCallBack);
						}
						</script>
						<div class="fadein"></div>
						<div class="post">
							<h2>Please log in</h2>
							<div id="response"></div>
							<form id="loginform" accept-charset="utf-8">
								<label for="username">Username:</label>
								<input type="text" name="username" id="username"/>
								<label for="password">Password:</label>
								<input type="password" name="password" id="password"/>
								<br /><br />
								<input type="submit" class="submit" value="Login" onClick="login(); return false;"/>
							</form>
						</div>
						<div class="fadeout"></div>
