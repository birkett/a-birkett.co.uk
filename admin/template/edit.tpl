						<div class="post aero">
						{PAGEEDIT}
						{POSTEDIT}
						{NEWPOST}

						<script type="text/javascript" src="http://tinymce.cachefly.net/4.0/tinymce.min.js"></script>
						<script type="text/javascript">
							tinymce.init({
								selector: "textarea", browser_spellcheck : true, plugins: "code image link wordcount"
							});
						</script>
						<script type="text/javascript">
							function addslashes(str) 
							{
								return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
							}
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
											document.getElementById("response").innerHTML='<p class="success">Posted!</p>';
											tinymce.activeEditor.getBody().setAttribute('contenteditable', false);
											break;
										case 400:
											document.getElementById("response").innerHTML='<p class="failed">Bad request. Something was rejected.</p>';
											break;
										default:
											document.getElementById("response").innerHTML='<p class="failed">Unknown error.</p>';
										}
									}
								}
								xmlhttp.open("POST","{ADMINFOLDER}adminactions.php",true);
								{VARS1}
								var content = encodeURIComponent(addslashes(tinyMCE.activeEditor.getContent()));
								xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

								{VARS2}
							}
						</script>
						<form method="post">
							<textarea>{CONTENT}</textarea>
						</form>
						
						<a href="" onClick="doaction(); return false;"><p>Submit</p></a>
						</div>
