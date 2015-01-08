<?php
//-----------------------------------------------------------------------------
// Build the blog feed page
//      In: Unparsed template
//      Out: Parsed template
//-----------------------------------------------------------------------------
namespace ABirkett;

class FeedPageController extends BasePageController
{
    public function __construct(&$output)
    {
        header("Content-Type: application/xml; charset=utf-8");

        $db = GetDatabase();
        $te = TemplateEngine();

        $posts = GetPosts("page", 0, false);

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
