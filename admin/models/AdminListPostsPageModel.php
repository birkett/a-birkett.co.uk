<?php
/**
* AdminListPostsPageModel - glue between the database and Controller
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

class AdminListPostsPageModel extends AdminBasePageModel
{
    /**
     * Fetch a list of all posts
     * @return mixed[] Array of posts data
     */
    public function getAllPosts()
    {
        return $this->database->runQuery(
            "SELECT post_id, post_timestamp, post_title, post_draft" .
            " FROM blog_posts ORDER BY post_timestamp DESC"
        );
    }
}
