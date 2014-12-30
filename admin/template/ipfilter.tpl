						<script type="text/javascript">
							function doaction(inip)
							{
								if(inip != undefined) { document.getElementById("formip").value=inip; }
								
								document.getElementById("response").innerHTML='';
								if (window.XMLHttpRequest) { xmlhttp=new XMLHttpRequest(); }
								else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
								xmlhttp.onreadystatechange=function()
								{
									if (xmlhttp.readyState==4)
									{
										switch(xmlhttp.status)
										{
										case 200:
											document.getElementById("response").innerHTML='<p class="success">'+xmlhttp.response+'</p>';
											break;
										default:
											document.getElementById("response").innerHTML='<p class="failed">'+xmlhttp.response+'</p>';
										}
									}
								}
								xmlhttp.open("POST","{ADMINFOLDER}adminactions.php",true);

								var ip = document.getElementById("formip").value;
								xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

								if(inip != undefined) { xmlhttp.send("mode=removeip&ip="+ip); }
								else { xmlhttp.send("mode=addip&ip="+ip); }
							}
						</script>
						<div class="post aero">
							<h2>IP Filter</h2>
							<div id="response"></div>
							<form>
								<p>IP Address:</p>
								<input id="formip" type="text" size="65" value="">
							</form>
							<a href="" onClick="doaction(); return false;"><p>Submit</p></a>
							
							<table><tr><th>IP</th><th>Time blocked</th><th>Unblock</th><th>Comments</th></tr>
								{IPFILTERENTRY}
								{LOOP}
								<tr>
									<td>{IP}</td>
									<td>{TIMESTAMP}</td>
									<td><a href="" onClick="doaction('{IP}'); return false;">Unblock</a></td>
									<td><a href="{ADMINFOLDER}index.php?action=listcomments&ip={IP}">Comments</a></td>
								</tr>
								{/LOOP}
							</table>
						</div>
