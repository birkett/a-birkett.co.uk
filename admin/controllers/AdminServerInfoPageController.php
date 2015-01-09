<?php
//-----------------------------------------------------------------------------
// Build the listpages page
//      In: Unparsed template
//      Out: Parsed template
//-----------------------------------------------------------------------------
namespace ABirkett\controllers;

class AdminServerInfoPageController extends AdminBasePageController
{
    private $model;

    public function __construct(&$output)
    {
        $this->model = new \ABirkett\models\AdminServerInfoPageModel();
        $tags = [
            "{APACHEVERSION}" => $_SERVER["SERVER_SOFTWARE"],
            "{PHPVERSION}" => phpversion(),
            "{MYSQLVERSION}" => \ABirkett\GetDatabase()->ServerInfo(),
            "{MYSQLIEXT}" => (extension_loaded("MySQLi") ? "Yes" : "No"),
            "{PDOMYSQLEXT}" => (extension_loaded("PDO_MySQL") ? "Yes" : "No"),
            "{PHPCURLEXT}" => (extension_loaded("CURL") ? "Yes" : "No")
        ];
        \ABirkett\TemplateEngine()->parseTags($tags, $output);

        parent::__construct($output);
    }
}
