<?php
//-----------------------------------------------------------------------------
// Build the listposts page
//      In: Unparsed template
//      Out: Parsed template
//-----------------------------------------------------------------------------
namespace ABirkett\controllers;

class AdminListPostsPageController extends AdminBasePageController
{
    //-----------------------------------------------------------------------------
    // Fetch post data
    //		In: none
    //		Out: Post data
    //-----------------------------------------------------------------------------
    private function getAllPosts()
    {
        return \ABirkett\GetDatabase()->runQuery(
            "SELECT post_id, post_timestamp, post_title, post_draft FROM blog_posts ORDER BY post_timestamp DESC",
            array()
        );
    }

    public function __construct(&$output)
    {
        $te = \ABirkett\TemplateEngine();
        $result = $this->getAllPosts();
        while (list($id, $timestamp, $title, $draft) = \ABirkett\GetDatabase()->getRow($result)) {
            $draft ? $title .= " (DRAFT)" : $title .= "";
            $tags = [
                "{ADMINFOLDER}" => ADMIN_FOLDER,
                "{POSTID}" => $id,
                "{POSTTITLE}" => $title
            ];
            $temp = $te->logicTag("{LOOP}", "{/LOOP}", $output);
            $te->parseTags($tags, $temp);
            $temp .= "\n{LOOP}";
            $te->replaceTag("{LOOP}", $temp, $output);
        }
        $te->removeLogicTag("{LOOP}", "{/LOOP}", $output);

        parent::__construct($output);
    }
}
