<?php
//-----------------------------------------------------------------------------
// Parse essential tags in the admin basic page template
//		In: Unparsed template
//		Out: Parsed template
//
//  !!! All pages get parsed through here !!!
//-----------------------------------------------------------------------------
require_once("../controllers/basepage.controller.php");

class AdminBasePageController
{
	public function __construct(&$output, $title)
	{
		//Run the admin templates through the public controller first
		new BasePageController($output, $title);
		
		$tags = [
			"{ADMINFOLDER}" => ADMIN_FOLDER,
		];
		ParseTags($tags, $output);
	}
}
?>