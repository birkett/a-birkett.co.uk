<?php
/**
 * AdminBasePageController - pull data from the model to populate the template
 *
 * PHP Version 5.3
 *
 * @category  AdminControllers
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\controllers;

class AdminBasePageController extends BasePageController
{


    /**
     * Basic tags common to most (if not all) admin pages
     * @param string $output Unparsed template passed by reference.
     * @return none
     */
    public function __construct(&$output)
    {
        parent::__construct($output);
        $this->model = new \ABirkett\models\AdminBasePageModel();

        $tags = array('{ADMINFOLDER}' => ADMIN_FOLDER);
        $this->templateEngine->parseTags($tags, $output);

        $tags = array(
                 '{ADMINSTYLESHEET}',
                 '{/ADMINSTYLESHEET}',
                );
        $this->templateEngine->removeTags($tags, $output);

    }//end __construct()
}//end class
