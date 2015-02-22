<?php
/**
 * BlogPageModel - glue between the database and BlogPageController
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

class BlogPageModel extends BasePageModel
{


    /**
     * Get the post data and return it as an array
     * @param  integer $postid ID of the post to fetch.
     * @return array   Array of post data
     */
    public function getSinglePost($postid)
    {
        return $this->database->runQuery(
            'SELECT * FROM blog_posts WHERE post_id = :id AND post_draft = "0"',
            array(':id' => $postid)
        );

    }//end getSinglePost()


    /**
     * Get posts data and return it as an array
     * @param  integer $page Page number to fetch.
     * @return array   Array of posts data
     */
    public function getMultiplePosts($page)
    {
        return $this->database->runQuery(
            'SELECT * FROM blog_posts WHERE post_draft = "0"'.
            ' ORDER BY post_timestamp DESC LIMIT '.
            ($page * BLOG_POSTS_PER_PAGE).','.BLOG_POSTS_PER_PAGE
        );

    }//end getMultiplePosts()


    /**
     * Get the total number of public blog posts
     * @return array Array containing post count
     */
    public function getNumberOfPosts()
    {
        $count = $this->database->runQuery(
            'SELECT COUNT(*) from blog_posts WHERE post_draft = "0"'
        );
        return $count[0]['COUNT(*)'];

    }//end getNumberOfPosts()


    /**
     * Get the total number of comments on a post
     * @param  integer $postid ID of the post to count comments on.
     * @return array   Array containing comment count
     */
    public function getNumberOfComments($postid)
    {
        $count = $this->database->runQuery(
            'SELECT COUNT(*) FROM blog_comments WHERE post_id = :postid',
            array(":postid" => $postid)
        );
        return $count[0]['COUNT(*)'];

    }//end getNumberOfComments()


    /**
     * Get the comments for a specified post
     * @param  integer $postid ID of the post to fetch comments for.
     * @return array   array of comments data
     */
    public function getCommentsOnPost($postid)
    {
        return $this->database->runQuery(
            'SELECT comment_username, comment_text, comment_timestamp'.
            ' FROM blog_comments WHERE post_id = :pid'.
            ' ORDER BY comment_timestamp ASC',
            array(":pid" => $postid)
        );

    }//end getCommentsOnPost()
}//end class
