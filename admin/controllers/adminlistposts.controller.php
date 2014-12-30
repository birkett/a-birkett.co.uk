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
		$listpostsentry = LogicTag("{LOOP}", "{/LOOP}", $output);
		while(list($id, $timestamp, $title, $draft) = GetDatabase()->GetRow($result))
		{
			$draft ? $title .= " (DRAFT)" : $title .= "";
			$tags = [
				"{ADMINFOLDER}" => ADMIN_FOLDER,
				"{POSTID}" => $id,
				"{POSTTITLE}" => $title
			];
			$temp = $listpostsentry;
			ParseTags($tags, $temp);
			$temp .= "\n{LISTPOSTSENTRY}";
			ReplaceTag("{LISTPOSTSENTRY}", $temp, $output);		
		}
		RemoveLogicTag("{LOOP}", "{/LOOP}", $output);
		//Clean up the tags if not already replaced
		$cleantags = [ "{LISTPOSTSENTRY}" ];
		RemoveTags($cleantags, $output);
	}
}
?>