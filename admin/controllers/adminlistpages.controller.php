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
		while(list($id, $title) = GetDatabase()->GetRow($result))
		{
			$tags = [
				"{PAGEID}" => $id,
				"{PAGETITLE}" => $title
			];
			$temp = LogicTag("{LOOP}", "{/LOOP}", $output);
			ParseTags($tags, $temp);
			$temp .= "\n{LOOP}";
			ReplaceTag("{LOOP}", $temp, $output);	
		}
		RemoveLogicTag("{LOOP}", "{/LOOP}", $output);
	}
}
?>