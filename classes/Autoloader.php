<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2015 Anthony Birkett
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 *
 * PHP Version 5.3
 *
 * @category  Autoloader
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\classes;

/**
 * Provides a PSR-4 compliant autoloader, and calls the site config.
 *
 * A call to Autoloader::init() should be the first call on an index page, as
 * this will autoload any classes called later. This also creates a site config
 * instance making sure symbols are available immediatly after the call to
 * Autoloader::init().
 *
 * The class autoloader will check for classes, controllers and models located
 * in either the root directory, or the admin directory. The public files will
 * always be attempted first, and admin files will only be attempted if being
 * requested from an admin page.
 *
 * @category  Autoloader
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */
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
        $c = new Config();

    }//end init()
}//end class
