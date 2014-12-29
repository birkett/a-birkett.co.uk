<?php
//-----------------------------------------------------------------------------
// Parse essential tags in the basic page template
//		In: Unparsed template
//		Out: Parsed template
//-----------------------------------------------------------------------------
class BasePageController
{
	public function __construct(&$output, $title)
	{
		$tags = [
			"{BASEURL}" => BASE_URL,
			"{TITLE}" => $title,
			"{RAND2551}" => rand(0, 255),
			"{RAND2552}" => rand(0, 255),
			"{RAND2553}" => rand(0, 255),	
			"{RAND12}" => rand(1, 2),
			"{THISYEAR}" => date('Y'),
			"{EXTRASTYLESHEET}" => (CHRISTMAS ? '<link rel="stylesheet" href="css/christmas.css" />' : "")
		];
		ParseTags($tags, $output);
	}
}
?>