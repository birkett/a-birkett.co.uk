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

require_once '../classes/Autoloader.php';

classes\Autoloader::init();

// Page router. Handles GET and POST requests.
$sessionManager = classes\SessionManager::getInstance();
$mode           = filter_input(INPUT_POST, 'mode', FILTER_SANITIZE_STRING);
$page           = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);

if (isset($mode) === true) {
    $obj = new controllers\AdminAJAXRequestController();
    return;
}

if ($sessionManager->isLoggedIn() === true) {
    // Logged in and requesting a page.
    if (isset($page) === true) {
        switch($page) {
            case 'password':
                $obj = new classes\Page(
                    'Admin :: Password',
                    'userwidget',
                    'password',
                    'AdminBasePageController'
                );
                break;

            case 'serverinfo':
                $obj = new classes\Page(
                    'Admin :: Server Info',
                    'userwidget',
                    'serverinfo',
                    'AdminServerInfoPageController'
                );
                break;

            case 'ipfilter':
                $obj = new classes\Page(
                    'Admin :: IP Filter',
                    'userwidget',
                    'ipfilter',
                    'AdminIPFilterPageController'
                );
                break;

            case 'listpages':
                $obj = new classes\Page(
                    'Admin :: Pages',
                    'userwidget',
                    'listpages',
                    'AdminListPagesPageController'
                );
                break;

            case 'listcomments':
                $obj = new classes\Page(
                    'Admin :: Comments',
                    'userwidget',
                    'listcomments',
                    'AdminListCommentsPageController'
                );
                break;

            case 'listposts':
                $obj = new classes\Page(
                    'Admin :: Posts',
                    'userwidget',
                    'listposts',
                    'AdminListPostsPageController'
                );
                break;

            case 'edit':
                $obj = new classes\Page(
                    'Admin :: Editor',
                    'userwidget',
                    'edit',
                    'AdminEditPageController'
                );
                break;

            default:
                $obj = new classes\Page(
                    'Admin :: Main',
                    'userwidget',
                    'index',
                    'AdminBasePageController'
                );
                break;
        }//end switch

        return;
    }//end if

    $obj = new classes\Page(
        'Admin :: Main',
        'userwidget',
        'index',
        'AdminBasePageController'
    );

    return;
}//end if

$obj = new classes\Page(
    'Admin :: Login',
    'userwidget',
    'login',
    'AdminBasePageController'
);
