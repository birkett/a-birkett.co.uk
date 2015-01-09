<?php
//-----------------------------------------------------------------------------
// Posts widget data
//-----------------------------------------------------------------------------
namespace ABirkett\models;

class PostsWidgetModel extends BasePageModel
{
    //-----------------------------------------------------------------------------
    // Fetch post data
    //		In: none
    //		Out: Post data
    //-----------------------------------------------------------------------------
    public function getAllPosts()
    {
        return $this->database->runQuery(
            "SELECT post_id, post_timestamp, post_title FROM blog_posts " .
            "WHERE post_draft = '0' ORDER BY post_timestamp DESC",
            array()
        );
    }
}
