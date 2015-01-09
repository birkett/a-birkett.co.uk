<?php
/**
* GenericPageController - pull data from the model to populate the template
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

class GenericPageController extends BasePageController
{
    /**
    * Store an instance of the model for this controller to use
    * @var object $model
    */
    private $model;

    /**
    * Build a generic page, with contents stored in the database
    * @param string $output Unparsed template passed by reference
    * @param string $name   Page name to fetch
    * @return none
    */
    public function __construct(&$output, $name)
    {
        parent::__construct($output);
        $this->model = new \ABirkett\models\GenericPageModel();
        $page = $this->model->getPage($name);
        $tags = [
            "{PAGETITLE}" => $page['page_title'],
            "{PAGECONTENT}" => stripslashes($page['page_content'])
        ];
        $this->templateEngine->parseTags($tags, $output);
    }
}
