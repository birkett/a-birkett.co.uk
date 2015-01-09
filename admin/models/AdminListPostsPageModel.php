<?php
//-----------------------------------------------------------------------------
// List Posts page data
//-----------------------------------------------------------------------------
namespace ABirkett\models;

class AdminListPostsPageModel
{
    //-----------------------------------------------------------------------------
    // Fetch post data
    //		In: none
    //		Out: Post data
    //-----------------------------------------------------------------------------
    public function getAllPosts()
    {
        return \ABirkett\GetDatabase()->runQuery(
            "SELECT post_id, post_timestamp, post_title, post_draft FROM blog_posts ORDER BY post_timestamp DESC",
            array()
        );
    }
}
