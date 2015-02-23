<?php
/**
 * AdminListPagesPageModel - glue between the database and Controller
 *
 * PHP Version 5.3
 *
 * @category  AdminModels
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\models;

class AdminListPagesPageModel extends AdminBasePageModel
{


    /**
     * Fetch a list of all pages
     * @return array Array of pages data
     */
    public function getAllPages()
    {
        return $this->database->runQuery(
            'SELECT page_id, page_title FROM site_pages'
        );

    }//end getAllPages()
}//end class
