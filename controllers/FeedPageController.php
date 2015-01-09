<?php
//-----------------------------------------------------------------------------
// Build the blog feed page
//      In: Unparsed template
//      Out: Parsed template
//-----------------------------------------------------------------------------
namespace ABirkett\controllers;

class FeedPageController extends BasePageController
{
    private $model;

    public function __construct(&$output)
    {
        parent::__construct($output);
        $this->model = new \ABirkett\models\FeedPageModel();

        header("Content-Type: application/xml; charset=utf-8");

        $posts = $this->model->getLatestPosts();

        $itemloop = $this->templateEngine->logicTag("{LOOP}", "{/LOOP}", $output);

        while (list($id, $timestamp, $title, $content, $draft) = $this->model->database->GetRow($posts)) {
            $temp = $itemloop;
            $tags = [
                "{POSTTITLE}" => $title,
                "{POSTID}" => $id,
                "{POSTTIMESTAMP}" => date("D, d M Y H:i:s O", $timestamp),
                "{POSTCONTENT}" => $content
            ];
            $this->templateEngine->parseTags($tags, $temp);
            $temp .= "\n{LOOP}";
            $this->templateEngine->replaceTag("{LOOP}", $temp, $output);
        }
        $this->templateEngine->removeLogicTag("{LOOP}", "{/LOOP}", $output);
    }
}
