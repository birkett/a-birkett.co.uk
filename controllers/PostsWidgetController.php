<?php
/**
* PostsWidgetController - pull data from the model to populate the template
*
* PHP Version 5.5
*
* @category Controllers
* @package  PersonalWebsite
* @author   Anthony Birkett <anthony@a-birkett.co.uk>
* @license  http://opensource.org/licenses/MIT MIT
* @link     http://www.a-birkett.co.uk
*/
namespace ABirkett\controllers;

class PostsWidgetController extends BasePageController
{
    /**
    * Build the posts widget
    * @param string $output Unparsed template passed by reference
    * @return none
    */
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

        $monthloop = $this->templateEngine->logicTag(
            "{MONTHLOOP}",
            "{/MONTHLOOP}",
            $output
        );
        $itemloop = $this->templateEngine->logicTag(
            "{ITEMLOOP}",
            "{/ITEMLOOP}",
            $output
        );
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
            $this->templateEngine->removeLogicTag(
                "{ITEMLOOP}",
                "{/ITEMLOOP}",
                $output
            );
        }
        $this->templateEngine->removeLogicTag(
            "{MONTHLOOP}",
            "{/MONTHLOOP}",
            $output
        );
        $tags = [ "{ITEMS}", "{MONTHS}" ];
        $this->templateEngine->removeTags($tags, $output);
    }
}
