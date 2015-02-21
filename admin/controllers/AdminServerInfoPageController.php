<?php
/**
 * AdminServeInfoPageController - pull data from model to populate the template
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

class AdminServerInfoPageController extends AdminBasePageController
{


    /**
     * Build the Server Info page
     * @param string $output Unparsed template passed by reference.
     * @return none
     */
    public function __construct(&$output)
    {
        parent::__construct($output);
        $this->model = new \ABirkett\models\AdminServerInfoPageModel();
        $tags = array(
            '{APACHEVERSION}' => $_SERVER['SERVER_SOFTWARE'],
            '{PHPVERSION}' => phpversion(),
            '{MYSQLVERSION}' => $this->model->database->ServerInfo(),
            '{MYSQLIEXT}' => (extension_loaded('MySQLi') ? 'Y' : 'N'),
            '{PDOMYSQLEXT}' => (extension_loaded('PDO_MySQL') ? 'Y' : 'N'),
            '{PHPCURLEXT}' => (extension_loaded('CURL') ? 'Y' : 'N'),
            '{PASSWORDHASH}' => (function_exists('password_hash') ? 'Y' : 'N')
        );
        $this->templateEngine->parseTags($tags, $output);

    }//end __construct()
}//end class
