					{LOGGEDIN}
					<p>Logged in as {USERNAME} <a href="{ADMINFOLDER}index.php?page=logout">(Logout)</a></p>
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
					<form>
						<input type="text" name="username" id="username"/>
						<input type="password" name="password" id="password"/>
						<br /><br />
						<input type="submit" class="submit" onClick="login(); return false;"/>
					</form>
					{/LOGIN}
