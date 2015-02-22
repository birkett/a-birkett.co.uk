<?php
/**
 * AdminListPagesPageController - pull data from model to populate the template
 *
 * PHP Version 5.4
 *
 * @category  AdminControllers
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\controllers;

class AdminListPagesPageController extends AdminBasePageController
{


    /**
     * Build the List Pages page
     * @param string $output Unparsed template passed by reference.
     * @return none
     */
    public function __construct(&$output)
    {
        parent::__construct($output);
        $this->model = new \ABirkett\models\AdminListPagesPageModel();
        $result      = $this->model->getAllPages();

        while ($row = $this->model->database->getRow($result)) {
            $tags = array(
                '{PAGEID}' => $row['page_id'],
                '{PAGETITLE}' => $row['page_title'],
            );
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
