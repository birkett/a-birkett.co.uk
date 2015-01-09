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
        $this->model = new \ABirkett\models\FeedPageModel();

        header("Content-Type: application/xml; charset=utf-8");

        $te = \ABirkett\TemplateEngine();

        $posts = $this->model->getLatestPosts();

        $itemloop = $te->logicTag("{LOOP}", "{/LOOP}", $output);

        while (list($id, $timestamp, $title, $content, $draft) = \ABirkett\GetDatabase()->GetRow($posts)) {
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
