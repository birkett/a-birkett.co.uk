<?php
/**
 * AJAXRequestModel - glue between the database and AJAXRequestController
 *
 * PHP Version 5.4
 *
 * @category  Models
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\models;

class AJAXRequestModel extends BasePageModel
{


    /**
     * Post a new comment
     * @param integer $postid   ID of the post the comment is for.
     * @param string  $username Comment author.
     * @param string  $comment  Comment text.
     * @param string  $clientip IP address of the author.
     * @return void
     */
    public function postComment($postid, $username, $comment, $clientip)
    {
        $this->database->runQuery(
            'INSERT INTO blog_comments('.
            'post_id, comment_username, comment_text, comment_timestamp, '.
            'client_ip) VALUES(:pid, :uname, :cmnt, :time, :ip)',
            array(
                ':pid' => $postid,
                ':uname' => $username,
                ':cmnt' => $comment,
                ':time' => time(),
                ':ip' => $clientip
            )
        );

    }//end postComment()


    /**
     * Get the post data and return it as an array
     * @param  integer $postid ID of the post to fetch.
     * @return array   Array of post data
     */
    public function getSinglePost($postid)
    {
        return $this->database->runQuery(
            "SELECT * FROM blog_posts WHERE post_id = :id AND post_draft = '0'",
            array(':id' => $postid)
        );

    }//end getSinglePost()


    /**
     * Check if an IP address is blacklisted
     * @param  string $ip IP address to check for.
     * @return string 1 on found, 0 when not found
     */
    public function checkIP($ip)
    {
        $count = $this->database->runQuery(
            'SELECT COUNT(*) from blocked_addresses WHERE address = :ip',
            array(':ip' => $ip)
        );
        return $count[0]['COUNT(*)'];

    }//end checkIP()
}//end class
