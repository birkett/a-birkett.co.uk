<?php
/**
 * BasePageModel - glue between the database and BasePageController
 *
 * PHP Version 5.5
 *
 * @category  Models
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\models;

class BasePageModel
{

    /**
     * Store a database instance - used by child classes
     * @var object $databse
     */
    public $database;


    /**
     * Get the base URL for the site (Protocol+Domain+TrailingSlash)
     * @return string URL
     */
    public function getBaseURL()
    {
        if (stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true) {
            $proto = 'https://';
        } else {
            $proto = 'http://';
        }

        return $proto . $_SERVER['HTTP_HOST'].'/';

    }//end getBaseURL()


    /**
     * Store a database instance, accessible from child classs
     */
    public function __construct()
    {
        $this->database = \ABirkett\classes\PDOMySQLDatabase::getInstance();

    }//end __construct()
}//end class
