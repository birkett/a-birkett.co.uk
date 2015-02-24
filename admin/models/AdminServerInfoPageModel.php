<?php
/**
 * AdminServerInfoPageModel - glue between the database and Controller
 *
 * PHP Version 5.3
 *
 * @category  AdminModels
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\models;

class AdminServerInfoPageModel extends AdminBasePageModel
{


    /**
     * Grab some basic server info, like versions and PHP module support
     * @return array Server data
     */
    public function getServerInfo()
    {
        $serverSoftware = filter_input(
            INPUT_SERVER,
            'SERVER_SOFTWARE',
            FILTER_SANITIZE_STRING
        );

        $data = array(
                 'version_php'         => phpversion(),
                 'version_apache'      => $serverSoftware,
                 'version_mysql'       => $this->database->serverInfo(),

                 'extension_pdo_mysql' => extension_loaded('pdo_mysql'),
                 'extension_curl'      => extension_loaded('curl'),
                 'extension_json'      => extension_loaded('json'),
                 'extension_date'      => extension_loaded('date'),
                 'extension_filter'    => extension_loaded('filter'),
                 'extension_hash'      => extension_loaded('hash'),
                 'extension_session'   => extension_loaded('session'),
                 'extension_pcre'      => extension_loaded('pcre'),
                 'extension_mcrypt'    => extension_loaded('mcrypt'),

                 'function_pass_hash'  => function_exists('password_hash'),
                 'function_http_code'  => function_exists('http_response_code'),
                );

        return $data;

    }//end getServerInfo()
}//end class
