<?php
//-----------------------------------------------------------------------------
// Page router
//-----------------------------------------------------------------------------
namespace ABirkett;

use ABirkett\classes\Page as Page;

require_once("config.php");
require_once("functions.php");

PHPDefaults();

//-----------------------------------------------------------------------------
// Page requests.
//-----------------------------------------------------------------------------
if (isset($_GET['page'])) {
    switch($_GET['page']) {
        case "about":
            new Page(SITE_TITLE . " :: About", "twitterwidget", "generic");
            break;
        case "blog":
            new Page(SITE_TITLE . " :: Blog", "postswidget", "blog");
            break;
        case "contact":
            new Page(SITE_TITLE . " :: Contact", "twitterwidget", "generic");
            break;
        case "photos":
            new Page(SITE_TITLE . " :: Photos", "twitterwidget", "generic");
            break;
        case "videos":
            new Page(SITE_TITLE . " :: Videos", "twitterwidget", "generic");
            break;
        case "projects":
            new Page(SITE_TITLE . " :: Projects", "twitterwidget", "generic");
            break;
        case "404":
            new Page(SITE_TITLE . " :: Error", "twitterwidget", "generic");
            break;
        case "feed":
            new Page(SITE_TITLE . " :: Blog Feed", "none", "feed");
            break;
        default:
            new Page(SITE_TITLE . " :: Home", "twitterwidget", "index");
    }
//-----------------------------------------------------------------------------
// AJAX actions.
//-----------------------------------------------------------------------------
} elseif (isset($_POST['mode'])) {
    new \ABirkett\controllers\AJAXRequestController();
} else {
//-----------------------------------------------------------------------------
// Default when nothing requested.
//-----------------------------------------------------------------------------
    new Page(SITE_TITLE . " :: Home", "twitterwidget", "index");
}
