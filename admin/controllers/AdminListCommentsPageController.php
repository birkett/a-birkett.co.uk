<?php
//-----------------------------------------------------------------------------
// Build the listcomments page
//      In: Unparsed template
//      Out: Parsed template
//-----------------------------------------------------------------------------
namespace ABirkett\controllers;

class AdminListCommentsPageController extends AdminBasePageController
{
    private $model;

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
            $temp = $this->templateEngine->logicTag("{LOOP}", "{/LOOP}", $output);
            $this->templateEngine->parseTags($tags, $temp);
            $temp .= "\n{LOOP}";
            $this->templateEngine->replaceTag("{LOOP}", $temp, $output);
        }
        $this->templateEngine->removeLogicTag("{LOOP}", "{/LOOP}", $output);
    }
}
