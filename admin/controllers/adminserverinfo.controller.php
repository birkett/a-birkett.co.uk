<?php
//-----------------------------------------------------------------------------
// Build the listpages page
//		In: Unparsed template
//		Out: Parsed template
//-----------------------------------------------------------------------------
class AdminServerInfoController
{
	public function __construct(&$output)
	{
		$tags = [
			"{APACHEVERSION}" => $_SERVER["SERVER_SOFTWARE"],
			"{PHPVERSION}" => phpversion(),
			"{MYSQLVERSION}" => GetDatabase()->ServerInfo()
		];
		ParseTags($tags, $output);
	}
}
?>