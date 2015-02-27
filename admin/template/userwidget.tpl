					{LOGGEDIN}
					<form accept-charset="utf-8">
						<input type="submit" class="submit" value="Logout ({USERNAME})" onClick="dologout(); return false;"/>
					</form>
					{/LOGGEDIN}
					{LOGIN}
					<script type="text/javascript" src="js/ajax.js"></script>
					<script type="text/javascript">
					function login()
					{
						SuccessCallBack = function() { location.reload(); }
						var username = document.getElementById("username").value;
						var password = document.getElementById("password").value;
						var data = "mode=login&username="+username+"&password="+password;

						AJAXOpen("{ADMINFOLDER}", data, SuccessCallBack);
					}
					</script>
					<div id="response"></div>
					<form accept-charset="utf-8">
						<input type="text" name="username" id="username"/>
						<input type="password" name="password" id="password"/>
						<br /><br />
						<input type="submit" class="submit" value="Login" onClick="login(); return false;"/>
					</form>
					{/LOGIN}
					<script type="text/javascript" src="js/ajax.js"></script>
					<script type="text/javascript">
						function dologout(inip)
						{
							SuccessCallBack = function() { return; }
							var data = "mode=logout";
							AJAXOpen("{ADMINFOLDER}", data, SuccessCallBack);
						}
					</script>
