						<script type="text/javascript" src="js/ajax.js"></script>
						<script type="text/javascript">
							function dologout(inip)
							{
								SuccessCallBack = function() { return; }
								var data = "mode=logout";
								AJAXOpen("{ADMINFOLDER}", data, SuccessCallBack);
							}
						</script>
						<div class="fadein"></div>
						<div id="response"></div>
						<div class="post">
							<a href="{ADMINFOLDER}index.php?page=listposts"><div class="tile posttile"><p class="tiletitle">Posts</p></div></a>
							<a href="{ADMINFOLDER}index.php?page=listcomments"><div class="tile commenttile"><p class="tiletitle">Comments</p></div></a>
							<a href="{ADMINFOLDER}index.php?page=listpages"><div class="tile pagetile"><p class="tiletitle">Pages</p></div></a>
							<a href="{ADMINFOLDER}index.php?page=edit"><div class="rectile posttile"><p class="tiletitle">New Post</p></div></a>
							<a href="{ADMINFOLDER}index.php?page=ipfilter"><div class="tile iptile"><p class="tiletitle">IP Filter</p></div></a>
							<a href="{ADMINFOLDER}index.php?page=serverinfo"><div class="tile infotile"><p class="tiletitle">Server Info</p></div></a>
							<a href="{ADMINFOLDER}index.php?page=password"><div class="tile passwordtile"><p class="tiletitle">Change Password</p></div></a>
							<a href="" onClick="dologout(); return false;"><div class="tile exittile"><p class="tiletitle">Logout</p></div></a>
						</div>
						<div class="fadeout"></div>
