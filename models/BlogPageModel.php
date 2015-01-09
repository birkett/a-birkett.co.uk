<?php
/**
* BlogPageModel - glue between the database and BlogPageController
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

class BlogPageModel extends BasePageModel
{
    /**
    * Get the post data and return it as an array
    * @param int $postid ID of the post to fetch
    * @return mixed[] Array of post data
    */
    public function getSinglePost($postid)
    {
        return $this->database->runQuery(
            "SELECT * FROM blog_posts WHERE post_id = :id AND post_draft = '0'",
            array(":id" => $postid)
        );
    }

    /**
    * Get posts data and return it as an array
    * @param int $page Page number to fetch
    * @return mixed[] Array of posts data
    */
    public function getMultiplePosts($page)
    {
        $limit1 = $page * BLOG_POSTS_PER_PAGE;
        $limit2 = BLOG_POSTS_PER_PAGE;
        return $this->database->runQuery(
            "SELECT * FROM blog_posts WHERE post_draft = '0'" .
            " ORDER BY post_timestamp DESC LIMIT $limit1,$limit2",
            array()
        );
    }

    /**
    * Get the total number of public blog posts
    * @return mixed[] Array containing post count
    */
    public function getNumberOfPosts()
    {
        $count = $this->database->runQuery(
            "SELECT COUNT(*) from blog_posts WHERE post_draft = '0'",
            array()
        );
        return $count[0]['COUNT(*)'];
    }

    /**
    * Get the total number of comments on a post
    * @param int $postid ID of the post to count comments on
    * @return mixed[] Array containing comment count
    */
    public function getNumberOfComments($postid)
    {
        $count = $this->database->runQuery(
            "SELECT COUNT(*) FROM blog_comments WHERE post_id = :postid",
            array(":postid" => $postid)
        );
        return $count[0]['COUNT(*)'];
    }

    /**
    * Get the comments for a specified post
    * @param int $postid ID of the post to fetch comments for
    * @return mixed[] array of comments data
    */
    public function getCommentsOnPost($postid)
    {
        return $this->database->runQuery(
            "SELECT comment_username, comment_text, comment_timestamp" .
            " FROM blog_comments WHERE post_id = :pid" .
            " ORDER BY comment_timestamp ASC",
            array(":pid" => $postid)
        );
    }
}
