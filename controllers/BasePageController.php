<?php
/**
* BasePageController - pull data from the model to populate the template
*
* PHP Version 5.5
*
* @category Controllers
* @package  PersonalWebsite
* @author   Anthony Birkett <anthony@a-birkett.co.uk>
* @license  http://opensource.org/licenses/MIT MIT
* @link     http://www.a-birkett.co.uk
*/
namespace ABirkett\controllers;

class BasePageController
{
    /**
    * Store an instance of the model for child controller to use
    * @var object $model
    */
    public $model;

    /**
    * Store an instance of the template engine for child controllers to use
    * @var object $templateEngine
    */
    public $templateEngine;

    /**
     * Parse some common tags present in most (if not all) templates
     * @param string $output Unparsed template passed by reference
     * @return none
     */
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
            $this->templateEngine->removeLogicTag(
                "{EXTRASTYLESHEETS}",
                "{/EXTRASTYLESHEETS}",
                $output
            );
        }
        if (!defined('ADMINPAGE')) {
            $this->templateEngine->removeLogicTag(
                "{ADMINSTYLESHEET}",
                "{/ADMINSTYLESHEET}",
                $output
            );
            $this->templateEngine->replaceTag("{ADMINFOLDER}", "", $output);
        }
    }
}
