<?php
/**
 * General site functions
 *
 * PHP Version 5.3
 *
 * @category  Functions
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett;

class Functions
{


    /**
     * Autoloader for classes, controllers and models
     * @param string $class Class name to load.
     * @return void
     */
    public static function autoloader($class)
    {
        $prefix = 'ABirkett\\';

        // Does the class use this namespace prefix?
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            return;
        }

        $relativeClass = substr($class, $len);

        $baseDir = __DIR__.'/';

        $endpath = str_replace('\\', '/', $relativeClass).'.php';
        $file    = $baseDir.$endpath;

        // Try the public folders.
        if (file_exists($file) === true) {
            require $file;
            return;
        }

        // Try the admin folder.
        if (defined('ADMINPAGE') === true) {
            $baseDir .= ADMIN_FOLDER;

            $file = $baseDir.$endpath;
            if (file_exists($file) === true) {
                require $file;
            }
        }

    }//end autoloader()


    /**
     * Setup some default PHP settings
     * @return void
     */
    public static function PHPDefaults()
    {
        // Show PHP errors and warnings.
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        // Timezone for converting timestamps.
        date_default_timezone_set('Europe/London');

        // Autoloader.
        spl_autoload_register('ABirkett\Functions::autoloader');

        //Site config
        Config::init();

    }//end PHPDefaults()


    /**
     * Define a symbol so public functions can act accordingly on an admin page
     * @return void
     */
    public static function declareAdminPage()
    {
        define('ADMINPAGE', 1);

    }//end declareAdminPage()
}//end class
