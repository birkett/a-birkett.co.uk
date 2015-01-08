<?php
//-----------------------------------------------------------------------------
// Build the listpages page
//      In: Unparsed template
//      Out: Parsed template
//-----------------------------------------------------------------------------
namespace ABirkett;

class AdminServerInfoPageController extends AdminBasePageController
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
        TemplateEngine()->parseTags($tags, $output);

        parent::__construct($output);
    }
}