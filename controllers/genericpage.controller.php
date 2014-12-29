<?php
//-----------------------------------------------------------------------------
// Build a generic page stored in the database
//		In: Unparsed template
//		Out: Parsed template
//-----------------------------------------------------------------------------
class GenericPageController
{
	public function __construct(&$output, $name)
	{
		$page = GetPage($name);
		$tags = [
			"{PAGETITLE}" => $page[0],
			"{PAGECONTENT}" => $page[1]
		];
		ParseTags($tags, $output);
	}
}
?>