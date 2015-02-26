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
 * @category  Classes
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\classes;

/**
 * Serves GET requests, by generating a page to display.
 *
 * Essentially, this is just a wrapper for the TemplateEngine and Controller,
 * making calls to load the page template, and create a controller instance.
 *
 * @category  Classes
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */
class Page
{


    /**
     * Generate a page
     * @param string $title      Page title.
     * @param string $widget     Request widget.
     * @param string $template   Requested template.
     * @param string $controller Page controller to use.
     * @return none
     */
    public function __construct($title, $widget, $template, $controller)
    {
        $tEngine = \ABirkett\classes\TemplateEngine::getInstance();

        $pagetemplate = ($template === 'feed') ? 'feed.tpl' : 'page.tpl';

        $page = $tEngine->loadPageTemplate($pagetemplate);

        $replacepage = $replacewidget = null;

        if ($template !== 'none') {
            $replacepage = $tEngine->loadSubTemplate($template.'.tpl');
        }

        if ($widget !== 'none') {
            $replacewidget = $tEngine->loadSubTemplate($widget.'.tpl');
        }

        $tags = array(
                 '{PAGE}'   => $replacepage,
                 '{WIDGET}' => $replacewidget,
                 '{TITLE}'  => $title,
                );

        $tEngine->parseTags($tags, $page);

        $controller = '\ABirkett\Controllers\\'.$controller;

        $pagecontroller = new $controller($page);

        if ($widget === 'postswidget') {
            $wcont = new \ABirkett\controllers\PostsWidgetController($page);
        }

        if ($widget === 'twitterwidget') {
            $wcont = new \ABirkett\controllers\TwitterWidgetController($page);
        }

        if ($widget === 'userwidget') {
            $wcont = new \ABirkett\controllers\AdminUserWidgetController($page);
        }

        // Destroy controller objects.
        unset($pagecontroller);
        unset($wcont);

        echo $page;

    }//end __construct()
}//end class
