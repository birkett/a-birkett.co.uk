<?php
/**
 * Page router - Routes GET and POST requests
 *
 * PHP Version 5.3
 *
 * @category  Index
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett;

require_once '../classes/Autoloader.php';

classes\Autoloader::init();
classes\SessionManager::begin();

$mode = filter_input(INPUT_POST, 'mode', FILTER_SANITIZE_STRING);
$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);

if (isset($mode) === true) {
    $p = new controllers\AdminAJAXRequestController();
} elseif (classes\SessionManager::isLoggedIn() === true) {
    // Logged in and requesting a page.
    if (isset($page) === true) {
        switch($page) {
            case 'password':
                $p = new classes\Page(
                    'Admin :: Password',
                    'userwidget',
                    'password',
                    'AdminBasePageController'
                );
                break;

            case 'serverinfo':
                $p = new classes\Page(
                    'Admin :: Server Info',
                    'userwidget',
                    'serverinfo',
                    'AdminServerInfoPageController'
                );
                break;

            case 'ipfilter':
                $p = new classes\Page(
                    'Admin :: IP Filter',
                    'userwidget',
                    'ipfilter',
                    'AdminIPFilterPageController'
                );
                break;

            case 'listpages':
                $p = new classes\Page(
                    'Admin :: Pages',
                    'userwidget',
                    'listpages',
                    'AdminListPagesPageController'
                );
                break;

            case 'listcomments':
                $p = new classes\Page(
                    'Admin :: Comments',
                    'userwidget',
                    'listcomments',
                    'AdminListCommentsPageController'
                );
                break;

            case 'listposts':
                $p = new classes\Page(
                    'Admin :: Posts',
                    'userwidget',
                    'listposts',
                    'AdminListPostsPageController'
                );
                break;

            case 'edit':
                $p = new classes\Page(
                    'Admin :: Editor',
                    'userwidget',
                    'edit',
                    'AdminEditPageController'
                );
                break;

            default:
                $p = new classes\Page(
                    'Admin :: Main',
                    'userwidget',
                    'index',
                    'AdminBasePageController'
                );
                break;
        }//end switch
    } else {
        $p = new classes\Page(
            'Admin :: Main',
            'userwidget',
            'index',
            'AdminBasePageController'
        );
    }//end if
} else {
    $p = new classes\Page(
        'Admin :: Login',
        'userwidget',
        'login',
        'AdminBasePageController'
    );
}//end if
