<?php
//-----------------------------------------------------------------------------
// Build the post list widget
//      In: Unparsed template
//      Out: Parsed template
//-----------------------------------------------------------------------------
namespace ABirkett;

class PostsWidgetController
{
    public function __construct(&$output)
    {
        $db = GetDatabase();
        $posts = GetPosts("all");
        $post_array = [];
        while (list($id, $timestamp, $title, $draft) = $db->GetRow($posts)) {
            $month = date("F Y", $timestamp);
            if (!isset($post_array["$month"])) {
                $post_array["$month"] = [];
            }
            $post_array["$month"][] = array("title" => $title, "id" => $id);
        }

        $monthloop = LogicTag("{MONTHLOOP}", "{/MONTHLOOP}", $output);
        $itemloop = LogicTag("{ITEMLOOP}", "{/ITEMLOOP}", $output);
        foreach ($post_array as $month => $data) {
            $temp = $monthloop;
            ReplaceTag("{MONTH}", $month, $temp);
            foreach ($data as $post) {
                $temp2 = $itemloop;
                $tags = [
                    "{POSTID}" => $post['id'],
                    "{POSTTITLE}" => $post['title']
                ];
                ParseTags($tags, $temp2);
                $temp2 .= "\n{ITEMLOOP}";
                ReplaceTag("{ITEMLOOP}", $temp2, $temp);
            }
            $temp .= "\n{MONTHLOOP}";
            ReplaceTag("{MONTHLOOP}", $temp, $output);
            RemoveLogicTag("{ITEMLOOP}", "{/ITEMLOOP}", $output);
        }
        RemoveLogicTag("{MONTHLOOP}", "{/MONTHLOOP}", $output);
        $tags = [ "{ITEMS}", "{MONTHS}" ];
        RemoveTags($tags, $output);
    }
}
