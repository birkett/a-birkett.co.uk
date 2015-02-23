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

require_once 'functions.php';

Functions::PHPDefaults();

$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
$mode = filter_input(INPUT_POST, 'mode', FILTER_SANITIZE_STRING);

if (isset($page) === true) {
    switch($page) {
        case 'about':
            new Page(
                SITE_TITLE.' :: About',
                'twitterwidget',
                'generic',
                'GenericPageController'
            );
            break;

        case 'blog':
            new Page(
                SITE_TITLE.' :: Blog',
                'postswidget',
                'blog',
                'BlogPageController'
            );
            break;

        case 'contact':
            new Page(
                SITE_TITLE.' :: Contact',
                'twitterwidget',
                'generic',
                'GenericPageController'
            );
            break;

        case 'photos':
            new Page(
                SITE_TITLE.' :: Photos',
                'twitterwidget',
                'generic',
                'GenericPageController'
            );
            break;

        case 'videos':
            new Page(
                SITE_TITLE.' :: Videos',
                'twitterwidget',
                'generic',
                'GenericPageController'
            );
            break;

        case 'projects':
            new Page(
                SITE_TITLE.' :: Projects',
                'twitterwidget',
                'generic',
                'GenericPageController'
            );
            break;

        case '404':
            new Page(
                SITE_TITLE.' :: Error',
                'twitterwidget',
                'generic',
                'GenericPageController'
            );
            break;

        case 'feed':
            new Page(
                SITE_TITLE.' :: Blog Feed',
                'none',
                'feed',
                'FeedPageController'
            );
            break;

        default:
            new Page(
                SITE_TITLE.' :: Home',
                'twitterwidget',
                'index',
                'BasePageController'
            );
            break;
    }//end switch
} elseif (isset($mode) === true) {
    new \ABirkett\controllers\AJAXRequestController();
} else {
    new Page(
        SITE_TITLE.' :: Home',
        'twitterwidget',
        'index',
        'BasePageController'
    );
}//end if
