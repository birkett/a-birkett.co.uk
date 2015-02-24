<?php
/**
 * BasePageController - pull data from the model to populate the template
 *
 * PHP Version 5.3
 *
 * @category  Controllers
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\controllers;

class BasePageController
{

    /**
     * Store an instance of the model for child controller to use
     * @var object $model
     */
    protected $model;

    /**
     * Store an instance of the template engine for child controllers to use
     * @var object $templateEngine
     */
    protected $templateEngine;


    /**
     * Parse some common tags present in most (if not all) templates
     * @param string $output Unparsed template passed by reference.
     * @return none
     */
    public function __construct(&$output)
    {
        $this->model          = new \ABirkett\models\BasePageModel();
        $this->templateEngine = \ABirkett\classes\TemplateEngine::getInstance();

        $tags = array(
                 '{BASEURL}'  => $this->model->getBaseURL(),
                 '{RAND2551}' => rand(0, 255),
                 '{RAND2552}' => rand(0, 255),
                 '{RAND2553}' => rand(0, 255),
                 '{RAND12}'   => rand(1, 2),
                 '{THISYEAR}' => date('Y'),
                );
        $this->templateEngine->parseTags($tags, $output);

        if (CHRISTMAS === 1) {
            $tags = array(
                     '{EXTRASTYLESHEETS}',
                     '{/EXTRASTYLESHEETS}',
                    );
            $this->templateEngine->removeTags($tags, $output);
        } else {
            $this->templateEngine->removeLogicTag(
                '{EXTRASTYLESHEETS}',
                '{/EXTRASTYLESHEETS}',
                $output
            );
        }

        if (defined('ADMINPAGE') === false) {
            $this->templateEngine->removeLogicTag(
                '{ADMINSTYLESHEET}',
                '{/ADMINSTYLESHEET}',
                $output
            );
            $this->templateEngine->replaceTag('{ADMINFOLDER}', '', $output);
        }

    }//end __construct()
}//end class
