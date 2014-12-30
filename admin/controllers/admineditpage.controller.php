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
		$vars1 = ""; $vars2 = "";
		
		//Page edit mode
		if(isset($_GET['pageid']))
		{
			$page = GetPage($_GET['pageid']);
			$content = $page[1];
			
			$vars1 .= 'var pageid = document.getElementById("formpageid").value;';
			$vars2 .= 'xmlhttp.send("mode=editpage&pageid="+pageid+"&content="+content);';
				
			ReplaceTag("{POSTID}", $_GET['pageid'], $output);
			RemoveLogicTag("{POSTEDIT}", "{/POSTEDIT}", $output);
			RemoveLogicTag("{NEWPOST}", "{/NEWPOST}", $output);
		}
		//Post edit mode
		else if (isset($_GET['postid']))
		{
			list($postid, $timestamp, $title, $content, $draft) = GetDatabase()->GetRow(GetPosts("single", $_GET['postid'], true));
			if($draft) $draft = "checked";
			
			$vars1 .= 'var postid = document.getElementById("formpostid").value;';
			$vars1 .= 'var title = document.getElementById("formtitle").value;';
			$vars1 .= 'var draft = document.getElementById("formdraft").checked;';
			$vars2 .= 'xmlhttp.send("mode=editpost&postid="+postid+"&title="+title+"&draft="+draft+"&content="+content);';

			$tags = [
				"{POSTID}" => $postid,
				"{POSTTITLE}" => $title,
				"{DRAFT}" => $draft
			];
			ParseTags($tags, $output);
			RemoveLogicTag("{PAGEEDIT}", "{/PAGEEDIT}", $output);
			RemoveLogicTag("{NEWPOST}", "{/NEWPOST}", $output);
		}
		//New post mode
		else
		{
			$vars1 .= 'var title = document.getElementById("formtitle").value;';
			$vars1 .= 'var draft = document.getElementById("formdraft").checked;';
			$vars2 .= 'xmlhttp.send("mode=newpost&title="+title+"&draft="+draft+"&content="+content);';
			 
			RemoveLogicTag("{PAGEEDIT}", "{/PAGEEDIT}", $output);
			RemoveLogicTag("{POSTEDIT}", "{/POSTEDIT}", $output);
		}
		ReplaceTag("{VARS1}", $vars1, $output);
		ReplaceTag("{VARS2}", $vars2, $output);
		isset($content) ? $content = $content : $content = "";
		ReplaceTag("{CONTENT}", $content, $output);
		//Clean up the tags if not already replaced
		$cleantags = [ "{NEWPOST}", "{/NEWPOST}", "{PAGEEDIT}", "{/PAGEEDIT}", "{POSTEDIT}", "{/POSTEDIT}" ];
		RemoveTags($cleantags, $output);
	}
}
?>