<?php
//-----------------------------------------------------------------------------
// List Posts page data
//-----------------------------------------------------------------------------
namespace ABirkett\models;

class AdminListPostsPageModel extends AdminBasePageModel
{
    //-----------------------------------------------------------------------------
    // Fetch post data
    //		In: none
    //		Out: Post data
    //-----------------------------------------------------------------------------
    public function getAllPosts()
    {
        return $this->database->runQuery(
            "SELECT post_id, post_timestamp, post_title, post_draft FROM blog_posts ORDER BY post_timestamp DESC",
            array()
        );
    }
}
