					<div class="middlec aero">
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
								xmlhttp.open("POST","<?php echo ADMIN_FOLDER; ?>adminactions.php",true);

								var ip = document.getElementById("formip").value;
								xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

								if(inip != undefined) { xmlhttp.send("mode=removeip&ip="+ip); }
								else { xmlhttp.send("mode=addip&ip="+ip); }
							}
						</script>
						<h2>IP Filter</h2>
						<div id="response"></div>
						<form>
							<p>IP Address:</p>
							<input id="formip" type="text" size="65" value="">
						</form>
						<a href="" onClick="doaction(); return false;"><p>Submit</p></a>
						
						<table><tr><th>IP</th><th>Time blocked</th><th>Unblock</th><th>Comments</th></tr>
						<?php
						$db = GetDatabase();
						$result = GetBlockedAddresses();
						while($row = $db->GetRow($result))
						{
							$id = $row[0];
							$ip = $row[1];
							$timestamp = $row[2];
							$unblocklink = '<a href="" onClick="doaction(\''.$ip.'\'); return false;">Unblock</a>';
							$commentslink = '<a href="'.ADMIN_FOLDER.'index.php?action=listcomments&ip='.$ip.'">Comments</a>';
							echo '<tr><td>' . $ip . '</td><td>' . date(DATE_FORMAT, $timestamp) . '</td><td>' . $unblocklink . '</td><td>' . $commentslink . '</td></tr>';
						}
						?>
						</table>
					</div>
					<?php require_once("template/sidewidget.tpl"); ?>
