<?php
/**
* AdminListCommentsPageController - pull data from the model to populate the template
*
* PHP Version 5.5
*
* @category AdminControllers
* @package  PersonalWebsite
* @author   Anthony Birkett <anthony@a-birkett.co.uk>
* @license  http://opensource.org/licenses/MIT MIT
* @link     http://www.a-birkett.co.uk
*/
namespace ABirkett\controllers;

class AdminListCommentsPageController extends AdminBasePageController
{
    /**
    * Build the List Comments page
    * @param string $output Unparsed template passed by reference
    * @return none
    */
    public function __construct(&$output)
    {
        parent::__construct($output);
        $this->model = new \ABirkett\models\AdminListCommentsPageModel();

        if (isset($_GET['ip'])) {
            $result = $this->model->getAllComments($_GET['ip']);
        } else {
            $result = $this->model->getAllComments();
        }
        while (list($id, $postid, $username, $comment, $timestamp, $ip) = $this->model->database->getRow($result)) {
            $tags = [
                "{COMMENT}" => $comment,
                "{USERNAME}" => $username,
                "{TIMESTAMP}" => date(DATE_FORMAT, $timestamp),
                "{IP}" => $ip,
                "{POSTID}" => $postid
            ];
            $temp = $this->templateEngine->logicTag(
                "{LOOP}",
                "{/LOOP}",
                $output
            );
            $this->templateEngine->parseTags($tags, $temp);
            $temp .= "\n{LOOP}";
            $this->templateEngine->replaceTag("{LOOP}", $temp, $output);
        }
        $this->templateEngine->removeLogicTag("{LOOP}", "{/LOOP}", $output);
    }
}
