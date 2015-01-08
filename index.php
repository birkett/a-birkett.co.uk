<?php
//-----------------------------------------------------------------------------
// Page router
//-----------------------------------------------------------------------------
namespace ABirkett;

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
    switch($_POST['mode']) {
        case "postcomment":
            if (
                !isset($_POST['postid']) ||
                !is_numeric($_POST['postid']) ||
                !isset($_POST['username']) ||
                !isset($_POST['comment']) ||
                !isset($_POST['challenge']) ||
                !isset($_POST['response'])
            ) {
                BadRequest("Something did not send correctly.");
            }
            $p = $_POST['postid'];
            $u = strip_tags($_POST['username']);
            $c = strip_tags($_POST['comment']);
            $ip = $_SERVER['REMOTE_ADDR'];
            $ch = $_POST['challenge'];
            $resp = $_POST['response'];

            if (GetDatabase()->GetNumRows(GetPosts("single", $p, false)) != 1) {
                BadRequest("Invalid Post ID.");
            }
            if ($u == "" || $c == "" || $ch == "" || $resp == "") {
                BadRequest("Please fill out all details.");
            }
            if (strlen($u) < 3 || strlen($u) > 20) {
                BadRequest("Username should be 3 - 20 characters");
            }
            if (strlen($c) < 10 || strlen($c) > 500) {
                BadRequest("Comment should be 10 - 500 characters");
            }
            if (CheckIP($ip)) {
                BlockedRequest("Your address is blocked. This is most likely due to spam.");
            }
            $recaptcha = new RecaptchaLib();
            $captcha = $recaptcha->checkAnswer(RECAPTHCA_PRIVATE_KEY, $ip, $ch, $resp);
            if ($captcha['is_valid'] == true) {
                PostComment($p, $u, $c, $ip);
                GoodRequest("Comment Posted!");
            } else {
                BadRequest("Captcha verification failed");
            }
    }
} else {
//-----------------------------------------------------------------------------
// Default when nothing requested.
//-----------------------------------------------------------------------------
    new Page(SITE_TITLE . " :: Home", "twitterwidget", "index");
}
