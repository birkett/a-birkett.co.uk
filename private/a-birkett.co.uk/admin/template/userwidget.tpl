					<div class="fadein"></div>
					<div class="post">
						<form accept-charset="utf-8">
							<input type="submit" class="submit" value="Logout ({USERNAME})" onClick="dologout(); return false;"/>
						</form>
						<script type="text/javascript" src="js/ajax.js"></script>
						<script type="text/javascript">
							function dologout(inip)
							{
								SuccessCallBack = function() { return; }
								var data = "mode=logout";
								AJAXOpen("{ADMINFOLDER}index.php?page=login", data, SuccessCallBack);
							}
						</script>
					</div>
					<div class="fadeout"></div>
