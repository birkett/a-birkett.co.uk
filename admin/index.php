<?php
//-----------------------------------------------------------------------------
// Admin index.
//
//  Page proxy for admin pages
//-----------------------------------------------------------------------------
namespace ABirkett;

session_start();

require_once("../config.php");
require_once("../functions.php");

DeclareAdminPage(); //Set so the page class will include admin controllers
PHPDefaults();

if (isset($_POST['mode'])) {
    new AdminAJAXRequestController();
} else if (isset($_SESSION['user'])) {
    if (isset($_GET['action'])) {
        switch($_GET['action']) {
            case "password":
                new Page("Admin :: Password", "userwidget", "password");
                break;
            case "serverinfo":
                new Page("Admin :: Server Info", "userwidget", "serverinfo");
                break;
            case "ipfilter":
                new Page("Admin :: IP Filter", "userwidget", "ipfilter");
                break;
            case "listpages":
                new Page("Admin :: List Pages", "userwidget", "listpages");
                break;
            case "listcomments":
                new Page("Admin :: List Comments", "userwidget", "listcomments");
                break;
            case "listposts":
                new Page("Admin :: List Posts", "userwidget", "listposts");
                break;
            case "edit":
                new Page("Admin :: Editor", "userwidget", "edit");
                break;
            case "logout":
                if (isset($_SESSION['user'])) {
                    unset($_SESSION['user']);
                    session_destroy();
                }
                new Page("Admin :: Login", "userwidget", "login");
                break;
            default:
                new Page("Admin :: Main", "userwidget", "index");
                break;
        }
    } else {
        new Page("Admin :: Main", "userwidget", "index"); //Default when nothing requested
    }
} else {
    new Page("Admin :: Login", "userwidget", "login");
}
