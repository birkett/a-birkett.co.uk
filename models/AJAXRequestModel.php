<?php
//-----------------------------------------------------------------------------
// Handle public AJAX requests
//-----------------------------------------------------------------------------
namespace ABirkett\models;

class AJAXRequestModel extends BasePageModel
{
    //-----------------------------------------------------------------------------
    // Post a new comment to the database
    //		In: Target post ID, Username, Text and IP address
    //		Out: none
    //-----------------------------------------------------------------------------
    public function postComment($postid, $username, $comment, $clientip)
    {
        $this->database->runQuery(
            "INSERT INTO blog_comments(post_id, comment_username, comment_text, comment_timestamp, client_ip)" .
            " VALUES(:postid, :username, :comment, :currenttime, :clientip)",
            array(
                ":postid" => $postid,
                ":username" => $username,
                ":comment" => $comment,
                ":currenttime" => time(),
                ":clientip" => $clientip
            )
        );
    }

    //-----------------------------------------------------------------------------
    // Fetch the specified post
    //		In: Post ID
    //		Out: Post data
    //-----------------------------------------------------------------------------
    public function getSinglePost($postid)
    {
        return $this->database->runQuery(
            "SELECT * FROM blog_posts WHERE post_id = :id AND post_draft = '0'",
            array(":id" => $postid)
        );
    }

    //-----------------------------------------------------------------------------
    // Checks if an IP is blocked
    //		In: IP address
    //		Out: TRUE on blocked, FALSE on not found
    //-----------------------------------------------------------------------------
    public function checkIP($ip)
    {
        $count = $this->database->runQuery(
            "SELECT COUNT(*) from blocked_addresses WHERE address = :ip",
            array(":ip" => $ip)
        );
        return $count[0]['COUNT(*)'];
    }
}
