<?php
//-----------------------------------------------------------------------------
// Build the post list widget
//      In: Unparsed template
//      Out: Parsed template
//-----------------------------------------------------------------------------
namespace ABirkett\controllers;

class PostsWidgetController extends BasePageController
{
    private $model;

    public function __construct(&$output)
    {
        $this->model = new \ABirkett\models\PostsWidgetModel();
        $te = \ABirkett\TemplateEngine();
        $posts = $this->model->getAllPosts();
        $post_array = [];
        while (list($id, $timestamp, $title) = \ABirkett\GetDatabase()->GetRow($posts)) {
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
