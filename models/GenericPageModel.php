<?php
/**
* GenericPageModel - glue between the database and GenericPageController
*
* PHP Version 5.5
*
* @category Models
* @package  PersonalWebsite
* @author   Anthony Birkett <anthony@a-birkett.co.uk>
* @license  http://opensource.org/licenses/MIT MIT
* @link     http://www.a-birkett.co.uk
*/
namespace ABirkett\models;

class GenericPageModel extends BasePageModel
{
    /**
    * Get the page data and return it as an array
    * @param string $pagename Name of the page to fetch
    * @return mixed[] Array of page data
    */
    public function getPage($pagename)
    {
        $page = $this->database->runQuery(
            "SELECT page_title, page_content FROM site_pages" .
            " WHERE page_name = :pn",
            array(":pn" => $pagename)
        );
        return $page[0];
    }
}
