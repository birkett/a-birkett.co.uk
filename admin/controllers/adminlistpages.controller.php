<?php
//-----------------------------------------------------------------------------
// Build the listpages page
//		In: Unparsed template
//		Out: Parsed template
//-----------------------------------------------------------------------------
class ListPagesPageController
{
	public function __construct(&$output)
	{
		$result = GetAllPages();
		$listpagesentry = "";
		while(list($id, $title) = GetDatabase()->GetRow($result))
		{
			$listpagesentry .= '<a href="'.ADMIN_FOLDER.'index.php?action=edit&pageid=' . $id . '"><p>' . $title . '</p></a>';
		}
		ReplaceTag("{LISTPAGESENTRY}", $listpagesentry, $output);
	}
}
?>