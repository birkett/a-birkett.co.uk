<?php
//-----------------------------------------------------------------------------
// List Comments page data
//-----------------------------------------------------------------------------
namespace ABirkett\models;

class AdminListCommentsPageModel
{
    //-----------------------------------------------------------------------------
    // Fetch all comments
    //      In: Optional IP Address
    //      Out: All comment data
    //-----------------------------------------------------------------------------
    public function getAllComments($ip = "")
    {
        return \ABirkett\GetDatabase()->runQuery(
            "SELECT * FROM blog_comments" . ($ip == "" ? " " : " WHERE client_ip='$ip' ") .
            "ORDER BY comment_timestamp DESC",
            array()
        );
    }
}
