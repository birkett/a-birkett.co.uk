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

use ABirkett\classes\Page as Page;

session_start();

require_once '../functions.php';

Functions::PHPDefaults();

$mode = filter_input(INPUT_POST, 'mode', FILTER_SANITIZE_STRING);
$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);

if (isset($mode) === true) {
    new \ABirkett\controllers\AdminAJAXRequestController();
} elseif (isset($_SESSION['user']) === true) {
    // Logged in and requesting a page.
    if (isset($page) === true) {
        switch($page) {
            case 'password':
                new Page(
                    'Admin :: Password',
                    'userwidget',
                    'password',
                    'AdminBasePageController'
                );
                break;

            case 'serverinfo':
                new Page(
                    'Admin :: Server Info',
                    'userwidget',
                    'serverinfo',
                    'AdminServerInfoPageController'
                );
                break;

            case 'ipfilter':
                new Page(
                    'Admin :: IP Filter',
                    'userwidget',
                    'ipfilter',
                    'AdminIPFilterPageController'
                );
                break;

            case 'listpages':
                new Page(
                    'Admin :: Pages',
                    'userwidget',
                    'listpages',
                    'AdminListPagesPageController'
                );
                break;

            case 'listcomments':
                new Page(
                    'Admin :: Comments',
                    'userwidget',
                    'listcomments',
                    'AdminListCommentsPageController'
                );
                break;

            case 'listposts':
                new Page(
                    'Admin :: Posts',
                    'userwidget',
                    'listposts',
                    'AdminListPostsPageController'
                );
                break;

            case 'edit':
                new Page(
                    'Admin :: Editor',
                    'userwidget',
                    'edit',
                    'AdminEditPageController'
                );
                break;

            case 'logout':
                unset($_SESSION['user']);
                session_destroy();
                new Page(
                    'Admin :: Login',
                    'userwidget',
                    'login',
                    'AdminBasePageController'
                );
                break;

            default:
                new Page(
                    'Admin :: Main',
                    'userwidget',
                    'index',
                    'AdminBasePageController'
                );
                break;
        }//end switch
    } else {
        new Page(
            'Admin :: Main',
            'userwidget',
            'index',
            'AdminBasePageController'
        );
    }//end if
} else {
    new Page(
        'Admin :: Login',
        'userwidget',
        'login',
        'AdminBasePageController'
    );
}//end if
