<?php
//-----------------------------------------------------------------------------
// Edit page data
//-----------------------------------------------------------------------------
namespace ABirkett\models;

class AdminEditPageModel
{
    //-----------------------------------------------------------------------------
    // Fetch page content
    //		In: Page ID
    //		Out: Page title and content
    //-----------------------------------------------------------------------------
    public function getPage($pageid)
    {
        $page = \ABirkett\GetDatabase()->runQuery(
            "SELECT page_title, page_content FROM site_pages WHERE page_id = :pageid",
            array(":pageid" => $pageid)
        );
        return $page[0];
    }

    //-----------------------------------------------------------------------------
    // Fetch the specified post
    //		In: Post ID
    //		Out: Post data
    //-----------------------------------------------------------------------------
    public function getSinglePost($postid)
    {
        return \ABirkett\GetDatabase()->runQuery(
            "SELECT * FROM blog_posts WHERE post_id = :id",
            array(":id" => $postid)
        );
    }
}
