<?php
/**
 * AdminIPFilterPageController - pull data from model to populate the template
 *
 * PHP Version 5.5
 *
 * @category  AdminControllers
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\controllers;

class AdminIPFilterPageController extends AdminBasePageController
{


    /**
     * Build the IP blacklist page
     * @param string $output Unparsed template passed by reference.
     * @return none
     */
    public function __construct(&$output)
    {
        parent::__construct($output);
        $this->model = new \ABirkett\models\AdminIPFilterPageModel();
        $result      = $this->model->getBlockedAddresses();

        while ($row = $this->model->database->GetRow($result)) {
            $tags = [
                '{IP}' => $row['address'],
                '{TIMESTAMP}' => date(DATE_FORMAT, $row['blocked_timestamp'])
            ];
            $temp = $this->templateEngine->logicTag(
                '{LOOP}',
                '{/LOOP}',
                $output
            );
            $this->templateEngine->parseTags($tags, $temp);
            $temp .= "\n{LOOP}";
            $this->templateEngine->replaceTag('{LOOP}', $temp, $output);
        }

        $this->templateEngine->removeLogicTag('{LOOP}', '{/LOOP}', $output);

    }//end __construct()
}//end class
