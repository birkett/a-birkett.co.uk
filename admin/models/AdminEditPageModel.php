<?php
/**
 * AdminEditPageModel - glue between the database and AdminEditPageController
 *
 * PHP Version 5.5
 *
 * @category  AdminModels
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\models;

class AdminEditPageModel extends AdminBasePageModel
{


    /**
     * Fetch a page
     * @param  integer $pageid ID of the page to fetch.
     * @return array   Array containing page data
     */
    public function getPage($pageid)
    {
        $page = $this->database->runQuery(
            'SELECT page_title, page_content FROM site_pages WHERE page_id = :pid',
            array(':pid' => $pageid)
        );
        return $page[0];

    }//end getPage()


    /**
     * Fetch a post
     * @param  integer $postid ID of the post to fetch.
     * @return array   Array containing post data
     */
    public function getSinglePost($postid)
    {
        return $this->database->runQuery(
            'SELECT * FROM blog_posts WHERE post_id = :id',
            array(':id' => $postid)
        );

    }//end getSinglePost()
}//end class
