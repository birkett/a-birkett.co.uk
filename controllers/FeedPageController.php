<?php
/**
* FeedPageController - pull data from the model to populate the template
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

class FeedPageController extends BasePageController
{
    /**
    * Build the blog feed page
    * @param string $output Unparsed template passed by reference
    * @return none
    */
    public function __construct(&$output)
    {
        parent::__construct($output);
        $this->model = new \ABirkett\models\FeedPageModel();

        header("Content-Type: application/xml; charset=utf-8");

        $posts = $this->model->getLatestPosts();

        $itemloop = $this->templateEngine->logicTag(
            "{LOOP}",
            "{/LOOP}",
            $output
        );

        while ($post = $this->model->database->GetRow($posts)) {
            $temp = $itemloop;
            $tags = [
                "{POSTTITLE}" =>
                    $post['post_title'],
                "{POSTID}" =>
                    $id,
                "{POSTTIMESTAMP}" =>
                    date("D, d M Y H:i:s O", $post['post_timestamp']),
                "{POSTCONTENT}" =>
                    $post['post_content']
            ];
            $this->templateEngine->parseTags($tags, $temp);
            $temp .= "\n{LOOP}";
            $this->templateEngine->replaceTag("{LOOP}", $temp, $output);
        }
        $this->templateEngine->removeLogicTag("{LOOP}", "{/LOOP}", $output);
    }
}
