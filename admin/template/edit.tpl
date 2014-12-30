						<div class="post aero">
						{PAGEEDIT}
							<h2>Edit Page</h2>
							<div id="response"></div>
							<form>
								<input id="formpageid" type="hidden" value="{POSTID}">
							</form>
						{/PAGEEDIT}
						{POSTEDIT}
							<h2>Edit Post</h2>
							<div id="response"></div>
							<form>
								<input id="formpostid" type="hidden" value="{POSTID}">
								<p>Post Title:</p>
								<input id="formtitle" type="text" size="65" value="{POSTTITLE}">
								<p>Draft</p>
								<input id="formdraft" type="checkbox" {DRAFT}>
							</form>
						{/POSTEDIT}
						{NEWPOST}
							<h2>New Post</h2>
							<div id="response"></div>
							<form>
								<p>Post Title:</p>
								<input id="formtitle" type="text" size="65" value="">
								<p>Draft</p>
								<input id="formdraft" type="checkbox">
							</form>
						{/NEWPOST}

						<script type="text/javascript" src="http://tinymce.cachefly.net/4.0/tinymce.min.js"></script>
						<script type="text/javascript">
							tinymce.init({
								selector: "textarea", browser_spellcheck : true, plugins: "code image link wordcount"
							});
						</script>
						<script type="text/javascript" src="js/ajax.js"></script>
						<script type="text/javascript">
							function addslashes(str) 
							{
								return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
							}
							
							function doedit()
							{
								var SuccessCallBack = function()
								{ tinymce.activeEditor.getBody().setAttribute('contenteditable', false); }
								
								var content = encodeURIComponent(addslashes(tinyMCE.activeEditor.getContent()));
								{VARS}
								
								AJAXOpen("{ADMINFOLDER}adminactions.php", data, SuccessCallBack);
							}
						</script>
						<form method="post">
							<textarea>{CONTENT}</textarea>
						</form>
						
						<a href="" onClick="doedit(); return false;"><p>Submit</p></a>
						</div>
