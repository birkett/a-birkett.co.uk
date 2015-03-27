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

require_once 'classes/Autoloader.php';

classes\Autoloader::init();

// Page router. Handles GET and POST requests.
$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
$mode = filter_input(INPUT_POST, 'mode', FILTER_SANITIZE_STRING);

if (isset($page) === true) {
    switch($page) {
        case 'about':
            $obj = new classes\Page(
                SITE_TITLE.' :: About',
                'twitterwidget',
                'generic',
                'GenericPageController'
            );
            break;

        case 'blog':
            $obj = new classes\Page(
                SITE_TITLE.' :: Blog',
                'postswidget',
                'blog',
                'BlogPageController'
            );
            break;

        case 'contact':
            $obj = new classes\Page(
                SITE_TITLE.' :: Contact',
                'twitterwidget',
                'generic',
                'GenericPageController'
            );
            break;

        case 'photos':
            $obj = new classes\Page(
                SITE_TITLE.' :: Photos',
                'twitterwidget',
                'generic',
                'GenericPageController'
            );
            break;

        case 'videos':
            $obj = new classes\Page(
                SITE_TITLE.' :: Videos',
                'twitterwidget',
                'generic',
                'GenericPageController'
            );
            break;

        case 'projects':
            $obj = new classes\Page(
                SITE_TITLE.' :: Projects',
                'twitterwidget',
                'generic',
                'GenericPageController'
            );
            break;

        case '404':
            $obj = new classes\Page(
                SITE_TITLE.' :: Error',
                'twitterwidget',
                'generic',
                'GenericPageController'
            );
            break;

        case 'feed':
            $obj = new classes\Page(
                SITE_TITLE.' :: Blog Feed',
                'none',
                'feed',
                'FeedPageController'
            );
            break;

        default:
            $obj = new classes\Page(
                SITE_TITLE.' :: Home',
                'twitterwidget',
                'index',
                'BasePageController'
            );
            break;
    }//end switch

    return;
}//end if

if (isset($mode) === true && isset($page) === false) {
    $nullpage = '';
    $obj = new classes\ControllerFactory('AJAXRequestController', $nullpage);
    return;
}

$obj = new classes\Page(
    SITE_TITLE.' :: Home',
    'twitterwidget',
    'index',
    'BasePageController'
);
