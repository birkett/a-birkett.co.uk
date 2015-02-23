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
    new controllers\AdminAJAXRequestController();
} elseif (classes\SessionManager::isLoggedIn() === true) {
    // Logged in and requesting a page.
    if (isset($page) === true) {
        switch($page) {
            case 'password':
                new classes\Page(
                    'Admin :: Password',
                    'userwidget',
                    'password',
                    'AdminBasePageController'
                );
                break;

            case 'serverinfo':
                new classes\Page(
                    'Admin :: Server Info',
                    'userwidget',
                    'serverinfo',
                    'AdminServerInfoPageController'
                );
                break;

            case 'ipfilter':
                new classes\Page(
                    'Admin :: IP Filter',
                    'userwidget',
                    'ipfilter',
                    'AdminIPFilterPageController'
                );
                break;

            case 'listpages':
                new classes\Page(
                    'Admin :: Pages',
                    'userwidget',
                    'listpages',
                    'AdminListPagesPageController'
                );
                break;

            case 'listcomments':
                new classes\Page(
                    'Admin :: Comments',
                    'userwidget',
                    'listcomments',
                    'AdminListCommentsPageController'
                );
                break;

            case 'listposts':
                new classes\Page(
                    'Admin :: Posts',
                    'userwidget',
                    'listposts',
                    'AdminListPostsPageController'
                );
                break;

            case 'edit':
                new classes\Page(
                    'Admin :: Editor',
                    'userwidget',
                    'edit',
                    'AdminEditPageController'
                );
                break;

            case 'logout':
                classes\SessionManager::destroy();
                new classes\Page(
                    'Admin :: Login',
                    'userwidget',
                    'login',
                    'AdminBasePageController'
                );
                break;

            default:
                new classes\Page(
                    'Admin :: Main',
                    'userwidget',
                    'index',
                    'AdminBasePageController'
                );
                break;
        }//end switch
    } else {
        new classes\Page(
            'Admin :: Main',
            'userwidget',
            'index',
            'AdminBasePageController'
        );
    }//end if
} else {
    new classes\Page(
        'Admin :: Login',
        'userwidget',
        'login',
        'AdminBasePageController'
    );
}//end if
