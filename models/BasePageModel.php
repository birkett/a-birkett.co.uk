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
 * @category  Models
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\models;

/**
 * Defines functionality used by all other models.
 *
 * All other models inherit from this, so we also store a database instance.
 * getBaseURL() will return the normalized base URL for the site, including the
 * request protocol ( HTTP/ HTTPS).
 *
 * @category  Models
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */
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
        $serverProtocol = filter_input(
            INPUT_SERVER,
            'SERVER_PROTOCOL',
            FILTER_SANITIZE_STRING
        );
        $serverHost     = filter_input(
            INPUT_SERVER,
            'HTTP_HOST',
            FILTER_UNSAFE_RAW
        );

        $proto = 'http://';

        if (stripos($serverProtocol, 'https') === true) {
            $proto = 'https://';
        }

        return $proto.$serverHost.'/';

    }//end getBaseURL()


    /**
     * Store a database instance, accessible from child classs
     */
    public function __construct()
    {
        $this->database = \ABirkett\classes\PDOMySQLDatabase::getInstance();

    }//end __construct()
}//end class
