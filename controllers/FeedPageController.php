<?php
//-----------------------------------------------------------------------------
// Build the blog feed page
//      In: Unparsed template
//      Out: Parsed template
//-----------------------------------------------------------------------------
namespace ABirkett;

class FeedPageController extends BasePageController
{
    //-----------------------------------------------------------------------------
    // Fetch the latest posts
    //		In: none
    //		Out: Post data
    //-----------------------------------------------------------------------------
    private function getLatestPosts()
    {
        $limit = BLOG_POSTS_PER_PAGE;
        return GetDatabase()->runQuery(
            "SELECT * FROM blog_posts WHERE post_draft = '0' ORDER BY post_timestamp DESC LIMIT 0,$limit",
            array()
        );
    }

    public function __construct(&$output)
    {
        header("Content-Type: application/xml; charset=utf-8");

        $te = TemplateEngine();

        $posts = $this->getLatestPosts();

        $itemloop = $te->logicTag("{LOOP}", "{/LOOP}", $output);

        while (list($id, $timestamp, $title, $content, $draft) = GetDatabase()->GetRow($posts)) {
            $temp = $itemloop;
            $tags = [
                "{POSTTITLE}" => $title,
                "{POSTID}" => $id,
                "{POSTTIMESTAMP}" => date("D, d M Y H:i:s O", $timestamp),
                "{POSTCONTENT}" => $content
            ];
            $te->parseTags($tags, $temp);
            $temp .= "\n{LOOP}";
            $te->replaceTag("{LOOP}", $temp, $output);
        }
        $te->removeLogicTag("{LOOP}", "{/LOOP}", $output);

        parent::__construct($output);
    }
}
