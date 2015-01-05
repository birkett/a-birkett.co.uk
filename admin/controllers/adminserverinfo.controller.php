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
			"{MYSQLVERSION}" => GetDatabase()->ServerInfo(),
			"{MYSQLIEXT}" => (extension_loaded("MySQLi") ? "Yes" : "No"),
			"{PDOMYSQLEXT}" => (extension_loaded("PDO_MySQL") ? "Yes" : "No"),
			"{PHPCURLEXT}" => (extension_loaded("CURL") ? "Yes" : "No")
		];
		ParseTags($tags, $output);
	}
}
?>