<?php
//-----------------------------------------------------------------------------
// Parse essential tags in the basic page template
//		In: Unparsed template
//		Out: Parsed template
//
//  !!! All pages get parsed through here !!!
//-----------------------------------------------------------------------------
class BasePageController
{
	public function __construct(&$output, $title)
	{
		$tags = [
			"{BASEURL}" => "//" . $_SERVER['HTTP_HOST'] . "/",
			"{TITLE}" => $title,
			"{RAND2551}" => rand(0, 255),
			"{RAND2552}" => rand(0, 255),
			"{RAND2553}" => rand(0, 255),	
			"{RAND12}" => rand(1, 2),
			"{THISYEAR}" => date('Y'),
		];
		ParseTags($tags, $output);
		
		if(CHRISTMAS)
		{
			$tags = [ "{EXTRASTYLESHEETS}", "{/EXTRASTYLESHEETS}" ];
			RemoveTags($tags, $output);
		}
		else
			RemoveLogicTag("{EXTRASTYLESHEETS}", "{/EXTRASTYLESHEETS}", $output);
	}
}
?>