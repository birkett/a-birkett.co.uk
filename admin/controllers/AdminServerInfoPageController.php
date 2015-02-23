<?php
/**
 * AdminServeInfoPageController - pull data from model to populate the template
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
        $serverData  = $this->model->getServerInfo();

        $tags = array(
            '{APACHEVERSION}' => $serverData['version_apache'],
            '{PHPVERSION}' => $serverData['version_php'],
            '{MYSQLVERSION}' => $serverData['version_mysql'],
            '{MYSQLIEXT}' => $serverData['extension_mysqli'],
            '{PDOMYSQLEXT}' => $serverData['extension_pdo_mysql'],
            '{PHPCURLEXT}' => $serverData['extension_curl'],
            '{PHPJSONEXT}' => $serverData['extension_json'],
            '{PHPDATEEXT}' => $serverData['extension_date'],
            '{PHPFILTEREXT}' => $serverData['extension_filter'],
            '{PASSWORDHASH}' => $serverData['function_password_hash'],
        );
        $this->templateEngine->parseTags($tags, $output);

    }//end __construct()
}//end class
