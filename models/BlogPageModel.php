<?php
//-----------------------------------------------------------------------------
// Blog page data
//-----------------------------------------------------------------------------
namespace ABirkett\models;

class BlogPageModel
{
    //-----------------------------------------------------------------------------
    // Fetch the specified post
    //		In: Post ID
    //		Out: Post data
    //-----------------------------------------------------------------------------
    public function getSinglePost($postid)
    {
        return \ABirkett\GetDatabase()->runQuery(
            "SELECT * FROM blog_posts WHERE post_id = :id AND post_draft = '0'",
            array(":id" => $postid)
        );
    }

    //-----------------------------------------------------------------------------
    // Fetch a page of posts
    //		In: Page number
    //		Out: Post data
    //-----------------------------------------------------------------------------
    public function getMultiplePosts($page)
    {
        $limit1 = $page * BLOG_POSTS_PER_PAGE;
        $limit2 = BLOG_POSTS_PER_PAGE;
        return \ABirkett\GetDatabase()->runQuery(
        "SELECT * FROM blog_posts WHERE post_draft = '0' ORDER BY post_timestamp DESC LIMIT $limit1,$limit2",
        array()
    );
    }

    //-----------------------------------------------------------------------------
    // Get the total number of blog posts
    //		In: none
    //		Out: Number of posts
    //-----------------------------------------------------------------------------
    public function getNumberOfPosts()
    {
        $count = \ABirkett\GetDatabase()->runQuery("SELECT COUNT(*) from blog_posts", array());
        return $count[0]['COUNT(*)'];
    }

    //-----------------------------------------------------------------------------
    // Get the total comments on a specified post
    //		In: Post ID
    //		Out: Number of comments on specified post
    //-----------------------------------------------------------------------------
    public function getNumberOfComments($postid)
    {
        $count = \ABirkett\GetDatabase()->runQuery(
        "SELECT COUNT(*) FROM blog_comments WHERE post_id = :postid",
        array(":postid" => $postid)
    );
    return $count[0]['COUNT(*)'];
    }

    //-----------------------------------------------------------------------------
    // Fetch the comments for specified post ID
    //		In: Post ID
    //		Out: All comments for post
    //-----------------------------------------------------------------------------
    public function getCommentsOnPost($postid)
    {
        return \ABirkett\GetDatabase()->runQuery(
        "SELECT * FROM blog_comments WHERE post_id = :postid ORDER BY comment_timestamp ASC ",
        array(":postid" => $postid)
        );
    }
}
