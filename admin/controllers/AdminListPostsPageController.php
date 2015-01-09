<?php
//-----------------------------------------------------------------------------
// Build the listposts page
//      In: Unparsed template
//      Out: Parsed template
//-----------------------------------------------------------------------------
namespace ABirkett\controllers;

class AdminListPostsPageController extends AdminBasePageController
{
    private $model;

    public function __construct(&$output)
    {
        parent::__construct($output);
        $this->model = new \ABirkett\models\AdminListPostsPageModel();
        $result = $this->model->getAllPosts();
        while (list($id, $timestamp, $title, $draft) = $this->model->database->getRow($result)) {
            $draft ? $title .= " (DRAFT)" : $title .= "";
            $tags = [
                "{ADMINFOLDER}" => ADMIN_FOLDER,
                "{POSTID}" => $id,
                "{POSTTITLE}" => $title
            ];
            $temp = $this->templateEngine->logicTag("{LOOP}", "{/LOOP}", $output);
            $this->templateEngine->parseTags($tags, $temp);
            $temp .= "\n{LOOP}";
            $this->templateEngine->replaceTag("{LOOP}", $temp, $output);
        }
        $this->templateEngine->removeLogicTag("{LOOP}", "{/LOOP}", $output);
    }
}
