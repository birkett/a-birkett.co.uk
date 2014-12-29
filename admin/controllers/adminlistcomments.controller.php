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

		$listcommentsentry = "";
		while(list($id, $postid, $username, $comment, $timestamp, $ip) = GetDatabase()->GetRow($result))
		{
			$link = '<a href="../blog/' . $postid . '"><p>' . $comment . '</p></a>';
			$filter = '<a href="'.ADMIN_FOLDER.'index.php?action=listcomments&ip='.$ip.'">'.$ip.'</a>';
			
			$listcommentsentry .= '<tr><td>' . $link . '</td><td>' . $username . '</td><td>' . date(DATE_FORMAT, $timestamp) . '</td><td>' . $filter . '</td></tr>';
		}
		
		ReplaceTag("{LISTCOMMENTSENTRY}", $listcommentsentry, $output);
	}
}
?>