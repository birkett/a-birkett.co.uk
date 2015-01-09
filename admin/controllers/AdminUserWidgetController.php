<?php
//-----------------------------------------------------------------------------
// Build the admin side widget
//      In: Unparsed template
//      Out: Parsed template
//-----------------------------------------------------------------------------
namespace ABirkett\controllers;

class AdminUserWidgetController extends AdminBasePageController
{
    public function __construct(&$output)
    {
        $te = \ABirkett\TemplateEngine();
        if (isset($_SESSION['user'])) {
            $te->removeLogicTag("{LOGIN}", "{/LOGIN}", $output);
            $te->replaceTag("{USERNAME}", $_SESSION['user'], $output);
        } else {
            $te->removeLogicTag("{LOGGEDIN}", "{/LOGGEDIN}", $output);
        }
        $cleantags = [ "{LOGIN}", "{/LOGIN}", "{LOGGEDIN}", "{/LOGGEDIN}" ];
        $te->removeTags($cleantags, $output);

        parent::__construct($output);
    }
}
