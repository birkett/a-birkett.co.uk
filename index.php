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
            new classes\Page(
                SITE_TITLE.' :: About',
                'twitterwidget',
                'generic',
                'GenericPageController'
            );
            break;

        case 'blog':
            new classes\Page(
                SITE_TITLE.' :: Blog',
                'postswidget',
                'blog',
                'BlogPageController'
            );
            break;

        case 'contact':
            new classes\Page(
                SITE_TITLE.' :: Contact',
                'twitterwidget',
                'generic',
                'GenericPageController'
            );
            break;

        case 'photos':
            new classes\Page(
                SITE_TITLE.' :: Photos',
                'twitterwidget',
                'generic',
                'GenericPageController'
            );
            break;

        case 'videos':
            new classes\Page(
                SITE_TITLE.' :: Videos',
                'twitterwidget',
                'generic',
                'GenericPageController'
            );
            break;

        case 'projects':
            new classes\Page(
                SITE_TITLE.' :: Projects',
                'twitterwidget',
                'generic',
                'GenericPageController'
            );
            break;

        case '404':
            new classes\Page(
                SITE_TITLE.' :: Error',
                'twitterwidget',
                'generic',
                'GenericPageController'
            );
            break;

        case 'feed':
            new classes\Page(
                SITE_TITLE.' :: Blog Feed',
                'none',
                'feed',
                'FeedPageController'
            );
            break;

        default:
            new classes\Page(
                SITE_TITLE.' :: Home',
                'twitterwidget',
                'index',
                'BasePageController'
            );
            break;
    }//end switch
} elseif (isset($mode) === true) {
    new controllers\AJAXRequestController();
} else {
    new classes\Page(
        SITE_TITLE.' :: Home',
        'twitterwidget',
        'index',
        'BasePageController'
    );
}//end if
