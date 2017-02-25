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

								AJAXOpen("{ADMINFOLDER}", data, SuccessCallBack);
							}
						</script>

						<div class="fadein"></div>
						<div class="post">
							<div id="response"></div>
							{PAGEEDIT}
								<h2>Edit Page</h2>

								<form accept-charset="utf-8">
									<input id="formpageid" type="hidden" value="{POSTID}"/>
							{/PAGEEDIT}
							{POSTEDIT}
								<h2>Edit Post</h2>
								<form accept-charset="utf-8">
									<input id="formpostid" type="hidden" value="{POSTID}"/>
									<p>Post Title:</p>
									<input id="formtitle" type="text" size="65" value="{POSTTITLE}"/>
									<p>Draft</p>
									<input id="formdraft" type="checkbox" {DRAFT}/>
							{/POSTEDIT}
							{NEWPOST}
								<h2>New Post</h2>
								<form accept-charset="utf-8">
									<p>Post Title:</p>
									<input id="formtitle" type="text" size="65" value=""/>
									<p>Draft</p>
									<input id="formdraft" type="checkbox"/>
							{/NEWPOST}
								<textarea>{CONTENT}</textarea>
								<br /><br />
								<input type="submit" class="submit" onClick="doedit(); return false;"/>
							</form>
						</div>
						<div class="fadeout"></div>
