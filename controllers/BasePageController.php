<?php
//-----------------------------------------------------------------------------
// Parse essential tags in the basic page template
//      In: Unparsed template
//      Out: Parsed template
//
//  !!! All pages get parsed through here !!!
//-----------------------------------------------------------------------------
namespace ABirkett\controllers;

class BasePageController
{
    private $model;
    public $templateEngine;

    public function __construct(&$output)
    {
        $this->model = new \ABirkett\models\BasePageModel();
        $this->templateEngine = \ABirkett\classes\TemplateEngine::getInstance();

        $tags = [
            "{BASEURL}" => $this->model->getBaseURL(),
            "{RAND2551}" => rand(0, 255),
            "{RAND2552}" => rand(0, 255),
            "{RAND2553}" => rand(0, 255),
            "{RAND12}" => rand(1, 2),
            "{THISYEAR}" => date('Y'),
        ];
        $this->templateEngine->parseTags($tags, $output);

        if (CHRISTMAS) {
            $tags = [ "{EXTRASTYLESHEETS}", "{/EXTRASTYLESHEETS}" ];
            $this->templateEngine->removeTags($tags, $output);
        } else {
            $this->templateEngine->removeLogicTag("{EXTRASTYLESHEETS}", "{/EXTRASTYLESHEETS}", $output);
        }
        if (!defined('ADMINPAGE')) {
            $this->templateEngine->removeLogicTag("{ADMINSTYLESHEET}", "{/ADMINSTYLESHEET}", $output);
            $this->templateEngine->replaceTag("{ADMINFOLDER}", "", $output);
        }
    }
}
