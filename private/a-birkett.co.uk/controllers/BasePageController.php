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
 * @category  Controllers
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\controllers;

use ABFramework\controllers\BasePageController as FrameworkBasePageController;

/**
 * Add some additional common tags to the framework BasePageController.
 *
 * @category  Controllers
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */
class BasePageController extends FrameworkBasePageController
{


    /**
     * Extend the framework default controller.
     *
     * @return none
     */
    public function __construct()
    {
        parent::__construct();

        $this->defineAction('GET', 'default', 'newDefaultGetHandler', array());
    }//end __construct()


    /**
     * Extend the framework default get handler, with some additional tags.
     *
     * @return none
     */
    public function newDefaultGetHandler()
    {
        parent::defaultGetRequest();

        $tags = array(
                 '{RAND2551}' => rand(0, 255),
                 '{RAND2552}' => rand(0, 255),
                 '{RAND2553}' => rand(0, 255),
                 '{RAND12}'   => rand(1, 2),
                );
        $this->templateEngine->parseTags($tags, $output);

        if (CHRISTMAS === 1) {
            $tags = array(
                     '{EXTRASTYLESHEETS}',
                     '{/EXTRASTYLESHEETS}',
                    );
            $this->templateEngine->removeTags($tags, $output);
        }
    }//end newDefaultGetHandler()
}//end class
