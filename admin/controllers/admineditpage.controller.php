<?php
//-----------------------------------------------------------------------------
// Build the editor page
//		In: Unparsed template
//		Out: Parsed template
//-----------------------------------------------------------------------------
class AdminEditPageController
{
	public function __construct(&$output)
	{
		new AdminBasePageController($output, "edit");
		
		//Page edit mode
		if(isset($_GET['pageid']))
		{
			$pageeditmode = true;
			$page = GetPage($_GET['pageid']);
			$content = $page[1];
			
			$pagecontent = OpenTemplate("editpage.tpl");
			ReplaceTag("{POSTID}", $_GET['pageid'], $pagecontent);
			ReplaceTag("{PAGEEDIT}", $pagecontent, $output);
		}
		//Post edit mode
		else if (isset($_GET['postid']))
		{
			$posteditmode = true;
			list($postid, $timestamp, $title, $content, $draft) = GetDatabase()->GetRow(GetPosts("single", $_GET['postid'], true));
			if($draft) $draft = "checked";
			
			$pagecontent = OpenTemplate("editpost.tpl");
			$tags = [
				"{POSTID}" => $postid,
				"{TITLE}" => $title,
				"{DRAFT}" => $draft
			];
			ParseTags($tags, $pagecontent);
			ReplaceTag("{POSTEDIT}", $pagecontent, $output);
		}
		//New post mode
		else
		{
			$newpostmode = true;
			$pagecontent = OpenTemplate("newpost.tpl");
			ReplaceTag("{NEWPOST}", $pagecontent, $output);
		}

		$vars1 = "";
		if(isset($posteditmode))
		{
			$vars1 .= 'var postid = document.getElementById("formpostid").value;';
			$vars1 .= 'var title = document.getElementById("formtitle").value;';
			$vars1 .= 'var draft = document.getElementById("formdraft").checked;';
		}
		if(isset($pageeditmode))
		{
			$vars1 .= 'var pageid = document.getElementById("formpageid").value;';
		}
		if(isset($newpostmode))
		{
			$vars1 .= 'var title = document.getElementById("formtitle").value;';
			$vars1 .= 'var draft = document.getElementById("formdraft").checked;';
		}
		ReplaceTag("{VARS1}", $vars1, $output);

		$vars2 = "";
		if(isset($posteditmode)) $vars2 .= 'xmlhttp.send("mode=editpost&postid="+postid+"&title="+title+"&draft="+draft+"&content="+content);';
		if(isset($pageeditmode)) $vars2 .= 'xmlhttp.send("mode=editpage&pageid="+pageid+"&content="+content);';
		if(isset($newpostmode))  $vars2 .= 'xmlhttp.send("mode=newpost&title="+title+"&draft="+draft+"&content="+content);';
		ReplaceTag("{VARS2}", $vars2, $output);

		isset($content) ? $content = $content : $content = "";
		ReplaceTag("{CONTENT}", $content, $output);
		
		//Clean up the tags if not already replaced
		$cleantags = [ "{NEWPOST}", "{PAGEEDIT}", "{POSTEDIT}" ];
		RemoveTags($cleantags, $output);
	}
}
?>