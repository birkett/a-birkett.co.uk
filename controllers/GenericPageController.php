<?php
/**
 * GenericPageController - pull data from the model to populate the template
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

class GenericPageController extends BasePageController
{


    /**
     * Build a generic page, with contents stored in the database
     * @param string $output Unparsed template passed by reference.
     * @return none
     */
    public function __construct(&$output)
    {
        parent::__construct($output);
        $this->model = new \ABirkett\models\GenericPageModel();
        $pagetitle   = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
        $e           = explode(' ', $pagetitle);
        $name        = strtolower(array_pop($e));
        $page        = $this->model->getPage($name);

        $tags        = array(
                        '{PAGETITLE}'   => $page['page_title'],
                        '{PAGECONTENT}' => stripslashes($page['page_content']),
                       );
        $this->templateEngine->parseTags($tags, $output);

    }//end __construct()
}//end class
