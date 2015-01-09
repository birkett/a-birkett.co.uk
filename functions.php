<?php
/**
* General site functions
*
* PHP Version 5.5
*
* @category Functions
* @package  PersonalWebsite
* @author   Anthony Birkett <anthony@a-birkett.co.uk>
* @license  http://opensource.org/licenses/MIT MIT
* @link     http://www.a-birkett.co.uk
*/
namespace ABirkett;

/**
* Autoloader for classes, controllers and models
* @param string $class Class name to load
* @return none
*/
function autoloader($class)
{
    $prefix = 'ABirkett\\';

    //Does the class use this namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);

    $base_dir = __DIR__ . "/";

    $endpath = str_replace('\\', '/', $relative_class) . '.php';
    $file = $base_dir . $endpath;

    //Try the public folders
    if (file_exists($file)) {
        require $file;
        return;
    }

    //Try the admin folder
    if (defined('ADMINPAGE')) {
        $base_dir .= ADMIN_FOLDER;

        $file = $base_dir . $endpath;
        if (file_exists($file)) {
            require $file;
        }
    }
}

/**
* Setup some default PHP settings
* @return none
*/
function PHPDefaults()
{
    //Show PHP errors and warnings
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    //Timezone for converting timestamps
    date_default_timezone_set("Europe/London");

    //Autoloader
    spl_autoload_register("ABirkett\autoloader");
}

/**
* Define a symbol so public functions can act accordingly on an admin page
* @return none
*/
function declareAdminPage()
{
    define('ADMINPAGE', 1);
}
