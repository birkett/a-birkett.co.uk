					<div class="middlec aero">
						<script type="text/javascript">
							function doaction()
							{		
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

								var cp = document.getElementById("formcp").value;
								var np = document.getElementById("formnp").value;
								var cnp = document.getElementById("formcnp").value;
								
								xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
								xmlhttp.send("mode=password&cp="+cp+"&np="+np+"&cnp="+cnp); 
							}
						</script>
						<h2>Password Reset</h2>
						<div id="response"></div>
						<form>
							<p>Current Password:</p>
							<input id="formcp" type="password" size="65" value="">
							<p>New Password:</p>
							<input id="formnp" type="password" size="65" value="">
							<p>Confirm New Password:</p>
							<input id="formcnp" type="password" size="65" value="">
						</form>
						<a href="" onClick="doaction(); return false;"><p>Submit</p></a>
					</div>
					<?php require_once("template/sidewidget.tpl"); ?>
