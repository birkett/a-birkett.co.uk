<?php
//-----------------------------------------------------------------------------
// Build the ipfilter page
//      In: Unparsed template
//      Out: Parsed template
//-----------------------------------------------------------------------------
namespace ABirkett\controllers;

class AdminIPFilterPageController extends AdminBasePageController
{
    private $model;

    public function __construct(&$output)
    {
        parent::__construct($output);
        $this->model = new \ABirkett\models\AdminIPFilterPageModel();
        $result = $this->model->getBlockedAddresses();
        while (list($ip_id, $address, $timestamp) = $this->model->database->GetRow($result)) {
            $tags = [
                "{IP}" => $address,
                "{TIMESTAMP}" => date(DATE_FORMAT, $timestamp)
            ];
            $temp = $this->templateEngine->logicTag("{LOOP}", "{/LOOP}", $output);
            $this->templateEngine->parseTags($tags, $temp);
            $temp .= "\n{LOOP}";
            $this->templateEngine->replaceTag("{LOOP}", $temp, $output);
        }
        $this->templateEngine->removeLogicTag("{LOOP}", "{/LOOP}", $output);
    }
}
