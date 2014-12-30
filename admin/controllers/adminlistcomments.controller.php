<?php
//-----------------------------------------------------------------------------
// Build the listcomments page
//		In: Unparsed template
//		Out: Parsed template
//-----------------------------------------------------------------------------
class ListCommentsPageController
{
	public function __construct(&$output)
	{
		if(isset($_GET['ip']))
			$result = GetAllComments($_GET['ip']);
		else
			$result = GetAllComments();

		$listcommentsentry = LogicTag("{LOOP}", "{/LOOP}", $output);

		while(list($id, $postid, $username, $comment, $timestamp, $ip) = GetDatabase()->GetRow($result))
		{
			$tags = [
				"{ADMINFOLDER}" => ADMIN_FOLDER,
				"{COMMENT}" => $comment,
				"{USERNAME}" => $username,
				"{TIMESTAMP}" => date(DATE_FORMAT, $timestamp),
				"{IP}" => $ip
			];
			$temp = $listcommentsentry;
			ParseTags($tags, $temp);
			$temp .= "\n{LISTCOMMENTSENTRY}";
			ReplaceTag("{LISTCOMMENTSENTRY}", $temp, $output);
		}
		RemoveLogicTag("{LOOP}", "{/LOOP}", $output);
		//Clean up the tags if not already replaced
		$cleantags = [ "{LISTCOMMENTSENTRY}" ];
		RemoveTags($cleantags, $output);
	}
}
?>