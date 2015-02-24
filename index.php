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

require_once 'classes\Autoloader.php';

classes\Autoloader::init();

$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
$mode = filter_input(INPUT_POST, 'mode', FILTER_SANITIZE_STRING);

if (isset($page) === true) {
    switch($page) {
        case 'about':
            $p = new classes\Page(
                SITE_TITLE.' :: About',
                'twitterwidget',
                'generic',
                'GenericPageController'
            );
            break;

        case 'blog':
            $p = new classes\Page(
                SITE_TITLE.' :: Blog',
                'postswidget',
                'blog',
                'BlogPageController'
            );
            break;

        case 'contact':
            $p = new classes\Page(
                SITE_TITLE.' :: Contact',
                'twitterwidget',
                'generic',
                'GenericPageController'
            );
            break;

        case 'photos':
            $p = new classes\Page(
                SITE_TITLE.' :: Photos',
                'twitterwidget',
                'generic',
                'GenericPageController'
            );
            break;

        case 'videos':
            $p = new classes\Page(
                SITE_TITLE.' :: Videos',
                'twitterwidget',
                'generic',
                'GenericPageController'
            );
            break;

        case 'projects':
            $p = new classes\Page(
                SITE_TITLE.' :: Projects',
                'twitterwidget',
                'generic',
                'GenericPageController'
            );
            break;

        case '404':
            $p = new classes\Page(
                SITE_TITLE.' :: Error',
                'twitterwidget',
                'generic',
                'GenericPageController'
            );
            break;

        case 'feed':
            $p = new classes\Page(
                SITE_TITLE.' :: Blog Feed',
                'none',
                'feed',
                'FeedPageController'
            );
            break;

        default:
            $p = new classes\Page(
                SITE_TITLE.' :: Home',
                'twitterwidget',
                'index',
                'BasePageController'
            );
            break;
    }//end switch
} elseif (isset($mode) === true) {
    $p = new controllers\AJAXRequestController();
} else {
    $p = new classes\Page(
        SITE_TITLE.' :: Home',
        'twitterwidget',
        'index',
        'BasePageController'
    );
}//end if
