<?php
//-----------------------------------------------------------------------------
// Build the admin side widget
//		In: Unparsed template
//		Out: Parsed template
//-----------------------------------------------------------------------------
class AdminSideWidgetController
{
	public function __construct(&$output)
	{
		new AdminBasePageController($output, "sidewidget");
		
		if(isset($_SESSION['user']))
		{
			$tags = [
				"{ADMINFOLDER}" => ADMIN_FOLDER,
				"{USERNAME}" => $_SESSION['user']
			];
			RemoveLogicTag("{LOGIN}", "{/LOGIN}", $output);
			ParseTags($tags, $output);
		} 
		else 
		{
			$tags = [ "{ADMINFOLDER}" => ADMIN_FOLDER ];
			RemoveLogicTag("{LOGGEDIN}", "{/LOGGEDIN}", $output);
			ParseTags($tags, $output);
		}
		//Clean up the tags if not already replaced
		$cleantags = [ "{LOGIN}", "{/LOGIN}", "{LOGGEDIN}", "{/LOGGEDIN}" ];
		RemoveTags($cleantags, $output);
	}
}
?>