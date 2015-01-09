<?php
//-----------------------------------------------------------------------------
// Build a generic page stored in the database
//      In: Unparsed template
//      Out: Parsed template
//
//  !!! This controller is only used for pages stored in the database !!!
//-----------------------------------------------------------------------------
namespace ABirkett\controllers;

class GenericPageController extends BasePageController
{
    private $model;

    public function __construct(&$output, $name)
    {
        $this->model = new \ABirkett\models\GenericPageModel();
        $page = $this->model->getPage($name);
        $tags = [
            "{PAGETITLE}" => $page['page_title'],
            "{PAGECONTENT}" => stripslashes($page['page_content'])
        ];
        \ABirkett\TemplateEngine()->parseTags($tags, $output);
        parent::__construct($output);
    }
}
