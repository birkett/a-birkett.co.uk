<?php
/**
 * AdminUserWidgetController - pull data from the model to populate the template
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

class AdminUserWidgetController extends AdminBasePageController
{


    /**
     * Build the user account widget
     * @param string $output Unparsed template passed by reference.
     * @return none
     */
    public function __construct(&$output)
    {
        parent::__construct($output);
        $this->model = new \ABirkett\models\AdminUserWidgetModel();
        $username    = \ABirkett\classes\SessionManager::getUser();

        // Username will not be set if not logged in.
        if (isset($username) === true) {
            $this->templateEngine->removeLogicTag(
                '{LOGIN}',
                '{/LOGIN}',
                $output
            );
            $this->templateEngine->replaceTag(
                '{USERNAME}',
                $username,
                $output
            );
        } else {
            $this->templateEngine->removeLogicTag(
                '{LOGGEDIN}',
                '{/LOGGEDIN}',
                $output
            );
        }

        $cleantags = array(
                      '{LOGIN}',
                      '{/LOGIN}',
                      '{LOGGEDIN}',
                      '{/LOGGEDIN}',
                     );
        $this->templateEngine->removeTags($cleantags, $output);

    }//end __construct()
}//end class
