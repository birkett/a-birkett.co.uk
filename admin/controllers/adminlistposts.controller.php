<?php
//-----------------------------------------------------------------------------
// Build the listposts page
//		In: Unparsed template
//		Out: Parsed template
//-----------------------------------------------------------------------------
class ListPostsPageController
{
	public function __construct(&$output)
	{
		$result = GetPosts("all", 0, true);
		$listpostsentry = "";
		while(list($id, $timestamp, $title, $draft) = GetDatabase()->GetRow($result))
		{
			$draft ? $draft = " (DRAFT)" : $draft = "";
			$listpostsentry .= '<a href="'.ADMIN_FOLDER.'index.php?action=edit&postid=' . $id . '"><p>' . $title . $draft . '</p></a>';
		}
		ReplaceTag("{LISTPOSTSENTRY}", $listpostsentry, $output);
	}
}
?>