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

use ABFramework\controllers\BasePageController;
use ABirkett\models\DatabasePageModel;

/**
 * Handles generating generic pages, whos content is stored in the database.
 *
 * This is the most common page controller for the public pages, and allows the
 * pages to be stored in the database, and easilly edited from the admin panel.
 *
 * @category  Controllers
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */
class DatabasePageController extends BasePageController
{


    /**
     * Build a generic page, with contents stored in the database
     * @return none
     */
    public function __construct()
    {
        parent::__construct();
        $this->model = new DatabasePageModel();
    }//end __construct()


    /**
     * Handle GET requests - display the application form.
     *
     * @param string $output Unparsed template passed by reference.
     *
     * @return void
     */
    public function getHandler(&$output)
    {
        $pagetitle   = $this->model->getGetVar('page', FILTER_SANITIZE_STRING);
        $exptitle    = explode(' ', $pagetitle);
        $name        = mb_strtolower(array_pop($exptitle));
        $page        = $this->model->getPage($name);

        if ($page === null) {
            $tags = array(
                     '{PAGETITLE}'   => 'Well, this is embarrasing.',
                     '{PAGECONTENT}' => 'There was an error fetching the page.',
                    );
            $this->templateEngine->parseTags($tags, $output);

            return;
        }

        $tags = array(
                 '{PAGETITLE}'   => $page->pageTitle,
                 '{PAGECONTENT}' => stripslashes($page->pageContent),
                );
        $this->templateEngine->parseTags($tags, $output);

        parent::getHandler($output);
    }//end getHandler()


    /**
     * Handle POST requests - Parse the application form input.
     *
     * @param string $output Unparsed template passed by reference.
     *
     * @return void
     */
    public function postHandler(&$output)
    {
        parent::postHandler($output);
    }//end postHandler()
}//end class
