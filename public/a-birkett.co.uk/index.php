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
 * @category  Index
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett;

use ABFramework\classes\Autoloader as Autoloader;
use ABFramework\classes\Page as Page;
use ABirkett\classes\Config as Config;

require_once '../../private/ABFramework/classes/Autoloader.php';

$autoloader = new Autoloader();

$autoloader->registerNamespace('ABFramework', '../../private/ABFramework/');
$autoloader->registerNamespace('ABirkett', '../../private/a-birkett.co.uk/');
$autoloader->init();

// Auto load the site and framework config.
$config = new Config();
unset($config);

// Page router. Handles GET and POST requests.
$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
$mode = filter_input(INPUT_POST, 'mode', FILTER_SANITIZE_STRING);
$obj  = null;

if (isset($page) === true) {
    switch($page) {
        case 'about':
            $obj = new Page('About');
            $obj->addMainTemplate('page');
            $obj->addSubTemplate('generic');
            $obj->addController('DatabasePageController', '\\ABirkett\controllers\\');
            $obj->addWidget('twitterwidget', 'TwitterWidgetController', '\\ABirkett\\controllers\\');
            break;

        case 'blog':
            $obj = new Page('Blog');
            $obj->addMainTemplate('page');
            $obj->addSubTemplate('blog');
            $obj->addController('BlogPageController', '\\ABirkett\controllers\\');
            $obj->addWidget('postswidget', 'PostsWidgetController', '\\ABirkett\\controllers\\');
            break;

        case 'contact':
            $obj = new Page('Contact');
            $obj->addMainTemplate('page');
            $obj->addSubTemplate('generic');
            $obj->addController('DatabasePageController', '\\ABirkett\controllers\\');
            $obj->addWidget('twitterwidget', 'TwitterWidgetController', '\\ABirkett\\controllers\\');
            break;

        case 'photos':
            $obj = new Page('Photos');
            $obj->addMainTemplate('page');
            $obj->addSubTemplate('generic');
            $obj->addController('DatabasePageController', '\\ABirkett\controllers\\');
            $obj->addWidget('twitterwidget', 'TwitterWidgetController', '\\ABirkett\\controllers\\');
            break;

        case 'videos':
            $obj = new Page('Videos');
            $obj->addMainTemplate('page');
            $obj->addSubTemplate('generic');
            $obj->addController('DatabasePageController', '\\ABirkett\controllers\\');
            $obj->addWidget('twitterwidget', 'TwitterWidgetController', '\\ABirkett\\controllers\\');
            break;

        case 'projects':
            $obj = new Page('Projects');
            $obj->addMainTemplate('page');
            $obj->addSubTemplate('generic');
            $obj->addController('DatabasePageController', '\\ABirkett\controllers\\');
            $obj->addWidget('twitterwidget', 'TwitterWidgetController', '\\ABirkett\\controllers\\');
            break;

        case '404':
            $obj = new Page('Error');
            $obj->addMainTemplate('page');
            $obj->addSubTemplate('generic');
            $obj->addController('DatabasePageController', '\\ABirkett\controllers\\');
            $obj->addWidget('twitterwidget', 'TwitterWidgetController', '\\ABirkett\\controllers\\');
            break;

        case 'feed':
            $obj = new Page('Blog Feed');
            $obj->addMainTemplate('feed');
            $obj->addController('FeedPageController', '\\ABirkett\controllers\\');
            break;

        default:
            $obj = new Page('Home');
		    $obj->addMainTemplate('page');
            $obj->addSubTemplate('index');
            $obj->addController('BasePageController');
            $obj->addWidget('twitterwidget', 'TwitterWidgetController', '\\ABirkett\\controllers\\');
            break;
    }//end switch

    $obj->sendOutput();
    return;
}//end if

$obj = new Page('Home');
$obj->addMainTemplate('page');
$obj->addSubTemplate('index');
$obj->addController('BasePageController');
$obj->addWidget('twitterwidget', 'TwitterWidgetController', '\\ABirkett\\controllers\\');

$obj->sendOutput();
