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
        parent::__construct($output);
        $this->model = new \ABirkett\models\PostsWidgetModel();
        $posts = $this->model->getAllPosts();
        $post_array = [];
        while (list($id, $timestamp, $title) = $this->model->database->GetRow($posts)) {
            $month = date("F Y", $timestamp);
            if (!isset($post_array["$month"])) {
                $post_array["$month"] = [];
            }
            $post_array["$month"][] = array("title" => $title, "id" => $id);
        }

        $monthloop = $this->templateEngine->logicTag("{MONTHLOOP}", "{/MONTHLOOP}", $output);
        $itemloop = $this->templateEngine->logicTag("{ITEMLOOP}", "{/ITEMLOOP}", $output);
        foreach ($post_array as $month => $data) {
            $temp = $monthloop;
            $this->templateEngine->replaceTag("{MONTH}", $month, $temp);
            foreach ($data as $post) {
                $temp2 = $itemloop;
                $tags = [
                    "{POSTID}" => $post['id'],
                    "{POSTTITLE}" => $post['title']
                ];
                $this->templateEngine->parseTags($tags, $temp2);
                $temp2 .= "\n{ITEMLOOP}";
                $this->templateEngine->replaceTag("{ITEMLOOP}", $temp2, $temp);
            }
            $temp .= "\n{MONTHLOOP}";
            $this->templateEngine->replaceTag("{MONTHLOOP}", $temp, $output);
            $this->templateEngine->removeLogicTag("{ITEMLOOP}", "{/ITEMLOOP}", $output);
        }
        $this->templateEngine->removeLogicTag("{MONTHLOOP}", "{/MONTHLOOP}", $output);
        $tags = [ "{ITEMS}", "{MONTHS}" ];
        $this->templateEngine->removeTags($tags, $output);
    }
}
