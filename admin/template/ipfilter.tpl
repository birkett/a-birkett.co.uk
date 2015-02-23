						<script type="text/javascript" src="js/ajax.js"></script>
						<script type="text/javascript">
							function ipblock(inip)
							{
								SuccessCallBack = function() { return; }
								if(inip != undefined) { document.getElementById("formip").value=inip; }
								var ip = document.getElementById("formip").value;

								if(inip != undefined) { var data = "mode=removeip&ip="+ip; }
								else { var data = "mode=addip&ip="+ip; }

								AJAXOpen("{ADMINFOLDER}", data, SuccessCallBack);
							}
						</script>
						<div class="fadein"></div>
						<div class="post">
						<h2>IP Filter</h2>
						<div id="response"></div>
						<form>
							<p>IP Address:</p>
							<input id="formip" type="text" size="65" value="">
						</form>
						<a href="" onClick="ipblock(); return false;"><p>Submit</p></a>

						<table><tr><th>IP</th><th>Time blocked</th><th>Unblock</th><th>Comments</th></tr>
							{LOOP}
							<tr>
								<td>{IP}</td>
								<td>{TIMESTAMP}</td>
								<td><a href="" onClick="ipblock('{IP}'); return false;">Unblock</a></td>
								<td><a href="{ADMINFOLDER}index.php?page=listcomments&ip={IP}">Comments</a></td>
							</tr>
							{/LOOP}
						</table>
						</div>
						<div class="fadeout"></div>
