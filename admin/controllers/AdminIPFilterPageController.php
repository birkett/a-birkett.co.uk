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
        $this->model = new \ABirkett\models\AdminIPFilterPageModel();
        $te = \ABirkett\TemplateEngine();
        $result = $this->model->getBlockedAddresses();
        while (list($ip_id, $address, $timestamp) = \ABirkett\GetDatabase()->GetRow($result)) {
            $tags = [
                "{IP}" => $address,
                "{TIMESTAMP}" => date(DATE_FORMAT, $timestamp)
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
