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
use ABFramework\classes\SessionManager as SessionManager;
use ABirkett\classes\Config as Config;

require_once '../../../private/ABFramework/classes/Autoloader.php';

$autoloader = new Autoloader();

$autoloader->registerNamespace('ABFramework', '../../../private/ABFramework/');
$autoloader->registerNamespace('ABirkett', '../../../private/a-birkett.co.uk/');
$autoloader->init();

// Auto load the site and framework config.
$config = new Config();
unset($config);

// Page router. Handles GET and POST requests.
$sessionManager = SessionManager::getInstance();
$mode           = filter_input(INPUT_POST, 'mode', FILTER_SANITIZE_STRING);
$page           = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);

if ($sessionManager->isLoggedIn() === true) {
    // Logged in and requesting a page.
    if (isset($page) === true) {
        switch($page) {
            case 'login':
				$obj = new Page('Admin :: Login');
				$obj->addMainTemplate('page');
				$obj->addSubTemplate('login');
				$obj->addController('AdminLoginPageController', '\\ABFramework\controllers\\');
				$obj->addWidget('userwidget', 'AdminUserWidgetController', '\\ABirkett\\controllers\\');
				break;

            case 'password':
                $obj = new Page('Admin :: Password');
                $obj->addMainTemplate('page');
                $obj->addSubTemplate('password');
                $obj->addController('AdminBasePageController', '\\ABFramework\controllers\\');
                $obj->addWidget('userwidget', 'AdminUserWidgetController', '\\ABirkett\\controllers\\');
                break;

            case 'serverinfo':
                $obj = new Page('Admin :: Server Info');
                $obj->addMainTemplate('page');
                $obj->addSubTemplate('serverinfo');
                $obj->addController('AdminServerInfoPageController', '\\ABFramework\controllers\\');
                $obj->addWidget('userwidget', 'AdminUserWidgetController', '\\ABirkett\\controllers\\');
                break;

            case 'ipfilter':
                $obj = new Page('Admin :: IP Filter');
                $obj->addMainTemplate('page');
                $obj->addSubTemplate('ipfilter');
                $obj->addController('AdminIPFilterPageController', '\\ABirkett\controllers\\');
                $obj->addWidget('userwidget', 'AdminUserWidgetController', '\\ABirkett\\controllers\\');
                break;

            case 'listpages':
                $obj = new Page('Admin :: Pages');
                $obj->addMainTemplate('page');
                $obj->addSubTemplate('listpages');
                $obj->addController('AdminListPagesPageController', '\\ABirkett\controllers\\');
                $obj->addWidget('userwidget', 'AdminUserWidgetController', '\\ABirkett\\controllers\\');
                break;

            case 'listcomments':
                $obj = new Page('Admin :: Comments');
                $obj->addMainTemplate('page');
                $obj->addSubTemplate('listcomments');
                $obj->addController('AdminListCommentsPageController', '\\ABirkett\controllers\\');
                $obj->addWidget('userwidget', 'AdminUserWidgetController', '\\ABirkett\\controllers\\');
                break;

            case 'listposts':
                $obj = new Page('Admin :: Posts');
                $obj->addMainTemplate('page');
                $obj->addSubTemplate('listposts');
                $obj->addController('AdminListPostsPageController', '\\ABirkett\controllers\\');
                $obj->addWidget('userwidget', 'AdminUserWidgetController', '\\ABirkett\\controllers\\');
                break;

            case 'edit':
                $obj = new Page('Admin :: Editor');
                $obj->addMainTemplate('page');
                $obj->addSubTemplate('edit');
                $obj->addController('AdminEditorPageController', '\\ABirkett\controllers\\');
                $obj->addWidget('userwidget', 'AdminUserWidgetController', '\\ABirkett\\controllers\\');
                break;

            default:
                $obj = new Page('Admin :: Main');
                $obj->addMainTemplate('page');
                $obj->addSubTemplate('index');
                $obj->addController('AdminBasePageController', '\\ABFramework\controllers\\');
                $obj->addWidget('userwidget', 'AdminUserWidgetController', '\\ABirkett\\controllers\\');
                break;
        }//end switch

         $obj->sendOutput();

        return;
    }//end if

    $obj = new Page('Admin :: Main');
    $obj->addMainTemplate('page');
    $obj->addSubTemplate('index');
    $obj->addController('AdminBasePageController', '\\ABFramework\controllers\\');
    $obj->addWidget('userwidget', 'AdminUserWidgetController', '\\ABirkett\\controllers\\');

    $obj->sendOutput();

    return;
}//end if

$obj = new Page('Admin :: Login');
$obj->addMainTemplate('page');
$obj->addSubTemplate('login');
$obj->addController('AdminLoginPageController', '\\ABFramework\controllers\\');
$obj->addWidget('userwidget', 'AdminUserWidgetController', '\\ABirkett\\controllers\\');

$obj->sendOutput();
