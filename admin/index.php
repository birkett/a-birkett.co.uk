<?php
/**
 * Page router - Routes GET and POST requests
 *
 * PHP Version 5.5
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

require_once '../config.php';
require_once '../functions.php';

Functions::declareAdminPage();
Functions::PHPDefaults();

if (isset($_POST['mode']) === true) {
    new \ABirkett\controllers\AdminAJAXRequestController();
} elseif (isset($_SESSION['user']) === true) {
    if (isset($_GET['action']) === true) {
        switch($_GET['action']) {
            case 'password':
                new Page('Admin :: Password', 'userwidget', 'password');
                break;

            case 'serverinfo':
                new Page('Admin :: Server Info', 'userwidget', 'serverinfo');
                break;

            case 'ipfilter':
                new Page('Admin :: IP Filter', 'userwidget', 'ipfilter');
                break;

            case 'listpages':
                new Page('Admin :: Pages', 'userwidget', 'listpages');
                break;

            case 'listcomments':
                new Page('Admin :: Comments', 'userwidget', 'listcomments');
                break;

            case 'listposts':
                new Page('Admin :: Posts', 'userwidget', 'listposts');
                break;

            case 'edit':
                new Page('Admin :: Editor', 'userwidget', 'edit');
                break;

            case 'logout':
                if (isset($_SESSION['user']) === true) {
                    unset($_SESSION['user']);
                    session_destroy();
                }

                new Page('Admin :: Login', 'userwidget', 'login');
                break;

            default:
                new Page('Admin :: Main', 'userwidget', 'index');
                break;
        }//end switch
    } else {
        new Page('Admin :: Main', 'userwidget', 'index');
    }//end if
} else {
    new Page('Admin :: Login', 'userwidget', 'login');
}//end if
