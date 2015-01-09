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
        $this->model = new \ABirkett\models\AdminListCommentsPageModel();
        $te = \ABirkett\TemplateEngine();

        if (isset($_GET['ip'])) {
            $result = $this->model->getAllComments($_GET['ip']);
        } else {
            $result = $this->model->getAllComments();
        }
        while (list($id, $postid, $username, $comment, $timestamp, $ip) = \ABirkett\GetDatabase()->getRow($result)) {
            $tags = [
                "{COMMENT}" => $comment,
                "{USERNAME}" => $username,
                "{TIMESTAMP}" => date(DATE_FORMAT, $timestamp),
                "{IP}" => $ip,
                "{POSTID}" => $postid
            ];
            $temp = $te->logicTag("{LOOP}", "{/LOOP}", $output);
            $te->parseTags($tags, $temp);
            $temp .= "\n{LOOP}";
            $te->replaceTag("{LOOP}", $temp, $output);
        }
        $te->removeLogicTag("{LOOP}", "{/LOOP}", $output);

        parent::__construct($output);
    }
}
