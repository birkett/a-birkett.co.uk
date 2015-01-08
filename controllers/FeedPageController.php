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
        $posts = GetPosts("page", 0, false);

        $itemloop = LogicTag("{LOOP}", "{/LOOP}", $output);

        while (list($id, $timestamp, $title, $content, $draft) = GetDatabase()->GetRow($posts)) {
            $temp = $itemloop;
            $tags = [
                "{POSTTITLE}" => $title,
                "{POSTID}" => $id,
                "{POSTTIMESTAMP}" => date("D, d M Y H:i:s O", $timestamp),
                "{POSTCONTENT}" => $content
            ];
            ParseTags($tags, $temp);
            $temp .= "\n{LOOP}";
            ReplaceTag("{LOOP}", $temp, $output);
        }
        RemoveLogicTag("{LOOP}", "{/LOOP}", $output);

        $tags = [
            "{BASEURL}" => GetBaseURL(),
            "{SITETITLE}" => SITE_TITLE,
            "{THISYEAR}" => date('Y'),
        ];
        ParseTags($tags, $output);

        parent::__construct($output);
    }
}
