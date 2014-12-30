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
		$listpagesentry = LogicTag("{LOOP}", "{/LOOP}", $output);
		while(list($id, $title) = GetDatabase()->GetRow($result))
		{
			$tags = [
				"{ADMINFOLDER}" => ADMIN_FOLDER,
				"{PAGEID}" => $id,
				"{PAGETITLE}" => $title
			];
			$temp = $listpagesentry;
			ParseTags($tags, $temp);
			$temp .= "\n{LISTPAGESENTRY}";
			ReplaceTag("{LISTPAGESENTRY}", $temp, $output);	
		}
		RemoveLogicTag("{LOOP}", "{/LOOP}", $output);
		//Clean up the tags if not already replaced
		$cleantags = [ "{LISTPAGESENTRY}" ];
		RemoveTags($cleantags, $output);
	}
}
?>