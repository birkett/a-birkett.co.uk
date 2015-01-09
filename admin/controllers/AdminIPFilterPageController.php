<?php
/**
* AdminIPFilterPageController - pull data from the model to populate the template
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

class AdminIPFilterPageController extends AdminBasePageController
{
    /**
    * Build the IP blacklist page
    * @param string $output Unparsed template passed by reference
    * @return none
    */
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
