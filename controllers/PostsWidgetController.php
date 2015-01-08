<?php
//-----------------------------------------------------------------------------
// Build the post list widget
//      In: Unparsed template
//      Out: Parsed template
//-----------------------------------------------------------------------------
namespace ABirkett;

class PostsWidgetController extends BasePageController
{
    public function __construct(&$output)
    {
        $db = GetDatabase();
        $te = TemplateEngine();
        $posts = GetPosts("all");
        $post_array = [];
        while (list($id, $timestamp, $title, $draft) = $db->GetRow($posts)) {
            $month = date("F Y", $timestamp);
            if (!isset($post_array["$month"])) {
                $post_array["$month"] = [];
            }
            $post_array["$month"][] = array("title" => $title, "id" => $id);
        }

        $monthloop = $te->logicTag("{MONTHLOOP}", "{/MONTHLOOP}", $output);
        $itemloop = $te->logicTag("{ITEMLOOP}", "{/ITEMLOOP}", $output);
        foreach ($post_array as $month => $data) {
            $temp = $monthloop;
            $te->replaceTag("{MONTH}", $month, $temp);
            foreach ($data as $post) {
                $temp2 = $itemloop;
                $tags = [
                    "{POSTID}" => $post['id'],
                    "{POSTTITLE}" => $post['title']
                ];
                $te->parseTags($tags, $temp2);
                $temp2 .= "\n{ITEMLOOP}";
                $te->replaceTag("{ITEMLOOP}", $temp2, $temp);
            }
            $temp .= "\n{MONTHLOOP}";
            $te->replaceTag("{MONTHLOOP}", $temp, $output);
            $te->removeLogicTag("{ITEMLOOP}", "{/ITEMLOOP}", $output);
        }
        $te->removeLogicTag("{MONTHLOOP}", "{/MONTHLOOP}", $output);
        $tags = [ "{ITEMS}", "{MONTHS}" ];
        $te->removeTags($tags, $output);

        parent::__construct($output);
    }
}
