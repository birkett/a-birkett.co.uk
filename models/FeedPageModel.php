<?php
//-----------------------------------------------------------------------------
// Feed page data
//-----------------------------------------------------------------------------
namespace ABirkett\models;

class FeedPageModel
{
    //-----------------------------------------------------------------------------
    // Fetch the latest posts
    //		In: none
    //		Out: Post data
    //-----------------------------------------------------------------------------
    public function getLatestPosts()
    {
        $limit = BLOG_POSTS_PER_PAGE;
            return \ABirkett\GetDatabase()->runQuery(
            "SELECT * FROM blog_posts WHERE post_draft = '0' ORDER BY post_timestamp DESC LIMIT 0,$limit",
            array()
        );
    }
}
