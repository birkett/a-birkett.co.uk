<?php
/**
 * PostsWidgetModel - glue between the database and PostsWidgetController
 *
 * PHP Version 5.3
 *
 * @category  Models
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\models;

class PostsWidgetModel extends BasePageModel
{


    /**
     * Get the post data and return it as an array
     * @return array Array of post data
     */
    public function getAllPosts()
    {
        return $this->database->runQuery(
            'SELECT post_id, post_timestamp, post_title FROM blog_posts '.
            'WHERE post_draft = "0" ORDER BY post_timestamp DESC'
        );

    }//end getAllPosts()
}//end class
