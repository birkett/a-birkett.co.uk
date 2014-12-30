					{LOGGEDIN}
					<p>Logged in as {USERNAME} <a href="{ADMINFOLDER}index.php?action=logout">(Logout)</a></p>
					{/LOGGEDIN}
					{LOGIN}
					<form action="{ADMINFOLDER}index.php?action=login" method="POST">
						<input type="text" name="username" id="username"/>
						<input type="password" name="password" id="password"/>
						<input type="submit" name="Submit" id="submit"/>
					</form>
					{/LOGIN}
