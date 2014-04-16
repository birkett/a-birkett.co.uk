					<script>
						function postcomment()
						{
							if (window.XMLHttpRequest) { xmlhttp=new XMLHttpRequest(); }
							else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
							xmlhttp.onreadystatechange=function()
							{
								if (xmlhttp.readyState==4)
								{
									switch(xmlhttp.status)
									{
									case 200:
										document.getElementById("response").innerHTML='<p class="success">Comment posted!</p>';
										document.getElementById("formusername").value="";
										document.getElementById("formcomment").value="";
										break;
									default:
										document.getElementById("response").innerHTML='<p class="failed">'+xmlhttp.response+'</p>';
									}
								}
							}
							xmlhttp.open("POST","actions.php",true);
							var p = document.getElementById("formpostid").value;
							var u = document.getElementById("formusername").value;
							var c = document.getElementById("formcomment").value;
							xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
							xmlhttp.send("mode=postcomment&postid="+p+"&username="+u+"&comment="+c+"&challenge="+Recaptcha.get_challenge()+"&response="+Recaptcha.get_response());
							Recaptcha.reload();
						}
					</script>
					<div class="middlec">
					<?php
					//Pagniation
					$offset = 0; //default
					if(isset($_GET['offset']) && is_numeric($_GET['offset']) && $_GET['offset'] >= 0 && $_GET['offset'] < 100000) { $offset = $_GET['offset']; } 

					//Single post mode
					if(isset($_GET['postid']) && is_numeric($_GET['postid']) && $_GET['postid'] >= 0 && $_GET['postid'] < 500000) 
					{ 
						$postid = $_GET['postid'];
						$result = GetPostByID($postid); 
						if(GetDatabase()->GetNumRows($result) == 0)
						{
							echo '<div class="post aero"><h2>The requested post was not found</h2></div>';						
							$failed = true;
						}
						$singlemode = true;
					}
					//Normal mode
					else { $result = GetLatestPosts($offset); }
						
					//Rendering code
					while($row = GetDatabase()->GetRow($result))
					{
						list($id, $timestamp, $title, $content, $draft) = $row;
						echo '<div class="post aero">';
						echo '<p class="timestamp">' . date(DATE_FORMAT, $timestamp) . '</p>';
						echo '<a href="/blog/' . $id . '"><h2>' . $title . '</h2></a>';
						echo $content;
						if(!isset($singlemode))
						{
							$numberofcomments = GetNumberOfComments($id);
							echo '<a class="right" href="/blog/' . $id . '">Comments(' . $numberofcomments . ')</a>';
						}
						echo '</div>';
					}
					
					//Show comments box if in single mode and on a valid post
					if(isset($singlemode) && !isset($failed))
					{
						$comments = GetCommentsOnPost($postid);
						$numberofcomments = GetDatabase()->GetNumRows($comments);
						if($numberofcomments != 0)
						{
							echo '<div class="post aero">';
							echo '<h2>Comments</h2>'; 
							while($comment = GetDatabase()->GetRow($comments))
							{
								$username = stripslashes($comment[2]);
								$text = stripslashes($comment[3]);
								$ctimestamp = $comment[4];
								echo '<p class="timestamp">Posted by ' . $username . ' on ' . date("l dS F Y", $ctimestamp) . '</p>';
								echo '<p class="aero">' . $text . '</p>';
								echo '<div class="divider"></div>';
							}
							echo '</div>';
						}
					}
					//Paginate when appropriate
					else if(!isset($failed) && GetNumberOfPosts() > BLOG_POSTS_PER_PAGE)
					{
						echo '<div class="post aero commentbox">';
						if($offset > 0) 
						{ echo '<a class="left" href="/blog/page/' . ($offset-1) . '">Previous page</a>'; }
						if(($offset+1) * BLOG_POSTS_PER_PAGE < GetNumberOfPosts()) 
						{ echo '<a class="right" href="/blog/page/' . ($offset+1) . '">Next page</a>'; }
						echo '</div>';
					}
					
					//Show new comment box when appropriate
					if(isset($singlemode) && !isset($failed))
					{
						echo '<div class="post aero commentbox">';
						echo '<h2>New comment</h2>';
						echo '<div id="response"></div>';
						echo '<form>';
						echo '<input id="formpostid" type="hidden" value="' . $postid .'">';
						echo '<p>Your name (3 - 20 characters):</p>';
						echo '<input id="formusername" type="text" size="50">';
						echo '<p>Comment (10 - 500 characters):</p>';
						echo '<textarea id="formcomment" rows="5" cols="40"></textarea>';
						echo '</form>';
						echo '<p>Verification:</p>';
						echo '<script type="text/javascript">var RecaptchaOptions = { theme : "blackglass" };</script>';
						echo '<script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=' . RECAPTCHA_PUBLIC_KEY . '"></script><br />';
						echo '<a href="" onClick="postcomment(); return false;">Submit</a>';
						echo '<br /><br /></div>';
					}
					?>
					</div>