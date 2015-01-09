<?php
//-----------------------------------------------------------------------------
// Build the admin side widget
//      In: Unparsed template
//      Out: Parsed template
//-----------------------------------------------------------------------------
namespace ABirkett\controllers;

class AdminUserWidgetController extends AdminBasePageController
{
    private $model;

    public function __construct(&$output)
    {
        parent::__construct($output);
        $this->model = new \ABirkett\models\AdminUserWidgetModel();
        if (isset($_SESSION['user'])) {
            $this->templateEngine->removeLogicTag("{LOGIN}", "{/LOGIN}", $output);
            $this->templateEngine->replaceTag("{USERNAME}", $_SESSION['user'], $output);
        } else {
            $this->templateEngine->removeLogicTag("{LOGGEDIN}", "{/LOGGEDIN}", $output);
        }
        $cleantags = [ "{LOGIN}", "{/LOGIN}", "{LOGGEDIN}", "{/LOGGEDIN}" ];
        $this->templateEngine->removeTags($cleantags, $output);
    }
}
