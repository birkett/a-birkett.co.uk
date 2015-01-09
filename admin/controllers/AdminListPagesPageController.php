<?php
//-----------------------------------------------------------------------------
// Build the listpages page
//      In: Unparsed template
//      Out: Parsed template
//-----------------------------------------------------------------------------
namespace ABirkett\controllers;

class AdminListPagesPageController extends AdminBasePageController
{
    private $model;

    public function __construct(&$output)
    {
        parent::__construct($output);
        $this->model = new \ABirkett\models\AdminListPagesPageModel();
        $result = $this->model->getAllPages();
        while (list($id, $title) = $this->model->database->getRow($result)) {
            $tags = [
                "{PAGEID}" => $id,
                "{PAGETITLE}" => $title
            ];
            $temp = $this->templateEngine->logicTag("{LOOP}", "{/LOOP}", $output);
            $this->templateEngine->parseTags($tags, $temp);
            $temp .= "\n{LOOP}";
            $this->templateEngine->replaceTag("{LOOP}", $temp, $output);
        }
        $this->templateEngine->removeLogicTag("{LOOP}", "{/LOOP}", $output);
    }
}
