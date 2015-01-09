<?php
//-----------------------------------------------------------------------------
// Parse essential tags in the admin basic page template
//      In: Unparsed template
//      Out: Parsed template
//
//  !!! All pages get parsed through here !!!
//-----------------------------------------------------------------------------
namespace ABirkett\controllers;

class AdminBasePageController extends BasePageController
{
    private $model;

    public function __construct(&$output)
    {
        parent::__construct($output);
        $this->model = new \ABirkett\models\AdminBasePageModel();

        $tags = [
            "{ADMINFOLDER}" => ADMIN_FOLDER,
        ];
        $this->templateEngine->parseTags($tags, $output);

        $tags = [ "{ADMINSTYLESHEET}", "{/ADMINSTYLESHEET}" ];
        $this->templateEngine->removeTags($tags, $output);
    }
}
