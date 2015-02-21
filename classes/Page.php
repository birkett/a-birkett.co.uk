<?php
/**
 * Serves GET request by serving a page
 *
 * PHP Version 5.5
 *
 * @category  Classes
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\classes;

class Page
{


    /**
     * Generate a page
     * @param string $title    Page title.
     * @param string $widget   Request widget.
     * @param string $template Requested template.
     * @return none
     */
    public function __construct($title, $widget, $template)
    {
        $te = \ABirkett\classes\TemplateEngine::getInstance();

        if ($template === 'feed') {
            $page = $te->loadPageTemplate('feed.tpl');
            $tags = array('{TITLE}' => $title);
        } else {
            $page = $te->loadPageTemplate('page.tpl');

            $tags = array(
                '{PAGE}' => $te->loadSubTemplate($template.'.tpl'),
                '{WIDGET}' => $te->loadSubTemplate($widget.'.tpl'),
                '{TITLE}' => $title
            );
        }

        $te->parseTags($tags, $page);

        if (defined('ADMINPAGE') === true) {
            switch ($template) {
                case 'listcomments':
                    new \ABirkett\controllers\AdminListCommentsPageController(
                        $page
                    );
                    break;

                case 'listposts':
                    new \ABirkett\controllers\AdminListPostsPageController(
                        $page
                    );
                    break;

                case 'listpages':
                    new \ABirkett\controllers\AdminListPagesPageController(
                        $page
                    );
                    break;

                case 'serverinfo':
                    new \ABirkett\controllers\AdminServerInfoPageController(
                        $page
                    );
                    break;

                case 'ipfilter':
                    new \ABirkett\controllers\AdminIPFilterPageController(
                        $page
                    );
                    break;

                case 'edit':
                    new \ABirkett\controllers\AdminEditPageController(
                        $page
                    );
                    break;

                default:
                    new \ABirkett\controllers\AdminBasePageController(
                        $page
                    );
                    break;
            }//end switch
            if ($widget === 'userwidget') {
                new \ABirkett\controllers\AdminUserWidgetController(
                    $page
                );
            }
        } else {
            switch ($template) {
                case 'generic':
                    // Get name from title last word.
                    $e = explode(' ', $title);
                    new \ABirkett\controllers\GenericPageController(
                        $page,
                        strtolower(array_pop($e))
                    );
                    break;

                case 'blog':
                    new \ABirkett\controllers\BlogPageController(
                        $page
                    );
                    break;

                case 'feed':
                    new \ABirkett\controllers\FeedPageController(
                        $page
                    );
                    break;

                default:
                    new \ABirkett\controllers\BasePageController(
                        $page
                    );
                    break;
            }//end switch
            if ($widget === 'postswidget') {
                new \ABirkett\controllers\PostsWidgetController(
                    $page
                );
            }

            if ($widget === 'twitterwidget') {
                new \ABirkett\controllers\TwitterWidgetController(
                    $page
                );
            }
        }//end if

        echo $page;

    }//end __construct()
}//end class
