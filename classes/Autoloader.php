<?php
/**
 * PSR-4 compliant class autoloader
 *
 * PHP Version 5.3
 *
 * @category  Autoloader
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\classes;

class Autoloader
{


    /**
     * Autoloader for classes, controllers and models
     * @return void
     */
    public static function init()
    {
        // Autoloader.
        spl_autoload_register(
            function($class) {
                $prefix = 'ABirkett\\';

                // Does the class use this namespace prefix?
                $len = strlen($prefix);
                if (strncmp($prefix, $class, $len) !== 0) {
                    return;
                }

                $relativeClass = substr($class, $len);

                $baseDir = __DIR__.'/../';

                $endpath = str_replace('\\', '/', $relativeClass).'.php';
                $file    = $baseDir.$endpath;

                // Try the public folders.
                if (file_exists($file) === true) {
                    include $file;
                    return;
                }

                // Try the admin folder.
                if (defined('ADMINPAGE') === true) {
                    $file = $baseDir.ADMIN_FOLDER.$endpath;
                    if (file_exists($file) === true) {
                        include $file;
                    }
                }
            }
        );

        // Auto load the site config.
        Config::init();

    }//end init()
}//end class
