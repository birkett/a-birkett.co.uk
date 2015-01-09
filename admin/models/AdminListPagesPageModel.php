<?php
/**
* AdminListPagesPageModel - glue between the database and Controller
*
* PHP Version 5.5
*
* @category AdminModels
* @package  PersonalWebsite
* @author   Anthony Birkett <anthony@a-birkett.co.uk>
* @license  http://opensource.org/licenses/MIT MIT
* @link     http://www.a-birkett.co.uk
*/
namespace ABirkett\models;

class AdminListPagesPageModel extends AdminBasePageModel
{
    /**
     * Fetch a list of all pages
     * @return mixed[] Array of pages data
     */
    public function getAllPages()
    {
        return $this->database->runQuery(
            "SELECT page_id, page_title from site_pages",
            array()
        );
    }
}
