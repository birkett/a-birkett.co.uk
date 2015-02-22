<?php
/**
 * FeedPageModel - glue between the database and FeedPageController
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

class FeedPageModel extends BasePageModel
{


    /**
     * Get the posts data and return it as an array
     * @return array Array of posts data
     */
    public function getLatestPosts()
    {
        return $this->database->runQuery(
            'SELECT post_id, post_timestamp, post_title, post_content'.
            ' FROM blog_posts WHERE post_draft = "0"'.
            ' ORDER BY post_timestamp DESC LIMIT 0,:lim',
            array(":lim" => BLOG_POSTS_PER_PAGE)
        );

    }//end getLatestPosts()
}//end class
