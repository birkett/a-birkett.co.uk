					<div class="middlec aero">
						<?php
						$db = GetDatabase();
						//Page edit mode
						if(isset($_GET['pageid']))
						{
							$pageeditmode = true;
							echo '<h2>Edit Page</h2>';
							$page = GetPage($_GET['pageid']);
							$content = $page[1];
							
							echo '<div id="response"></div>';
							echo '<form>';
							echo '<input id="formpageid" type="hidden" value="' . $_GET['pageid'] .'">';
							echo '</form>';
						}
						//Post edit mode
						else if (isset($_GET['postid']))
						{
							$posteditmode = true;
							echo '<h2>Edit Post</h2>';
							list($postid, $timestamp, $title, $content, $draft) = $db->GetRow(GetPosts("single", $_GET['postid'], true));
							if($draft) $draft = "checked";
							
							echo '<div id="response"></div>';
							echo '<form>';
							echo '<input id="formpostid" type="hidden" value="' . $postid .'">';
							echo '<p>Post Title:</p>';
							echo '<input id="formtitle" type="text" size="65" value="' . $title . '">';
							echo '<p>Draft</p>';
							echo '<input id="formdraft" type="checkbox" ' . $draft . '>';
							echo '</form>';
						}
						//New post mode
						else
						{
							$newpostmode = true;
							echo '<h2>New Post</h2>';
							echo '<div id="response"></div>';
							echo '<form>';
							echo '<p>Post Title:</p>';
							echo '<input id="formtitle" type="text" size="65" value="">';
							echo '<p>Draft</p>';
							echo '<input id="formdraft" type="checkbox">';
							echo '</form>';
						}
						?>
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
								xmlhttp.open("POST","<?php echo ADMIN_FOLDER; ?>adminactions.php",true);
								<?php
								if(isset($posteditmode))
								{
									echo 'var postid = document.getElementById("formpostid").value;';
									echo 'var title = document.getElementById("formtitle").value;';
									echo 'var draft = document.getElementById("formdraft").checked;';
								}
								if(isset($pageeditmode))
								{
									echo 'var pageid = document.getElementById("formpageid").value;';
								}
								if(isset($newpostmode))
								{
									echo 'var title = document.getElementById("formtitle").value;';
									echo 'var draft = document.getElementById("formdraft").checked;';
								}
								?>
								var content = encodeURIComponent(addslashes(tinyMCE.activeEditor.getContent()));
								xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

								<?php
								if(isset($posteditmode)) echo 'xmlhttp.send("mode=editpost&postid="+postid+"&title="+title+"&draft="+draft+"&content="+content);';
								if(isset($pageeditmode)) echo 'xmlhttp.send("mode=editpage&pageid="+pageid+"&content="+content);';
								if(isset($newpostmode))  echo 'xmlhttp.send("mode=newpost&title="+title+"&draft="+draft+"&content="+content);';
								?>
							}
						</script>
						<form method="post">
							<textarea><?php if(isset($content)) echo $content; ?></textarea>
						</form>
						
						<a href="" onClick="doaction(); return false;"><p>Submit</p></a>
					</div>
					<?php require_once("template/sidewidget.tpl"); ?>