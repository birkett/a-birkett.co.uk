<?php
/**
 * Serves GET request by serving a page
 *
 * PHP Version 5.3
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
     * @param string $title      Page title.
     * @param string $widget     Request widget.
     * @param string $template   Requested template.
     * @param string $controller Page controller to use.
     * @return none
     */
    public function __construct($title, $widget, $template, $controller)
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
                     '{TITLE}' => $title,
                    );
        }

        $te->parseTags($tags, $page);

        $controller = '\ABirkett\Controllers\\'.$controller;

        if ($template === 'generic') {
            // Get name from title last word.
            $e = explode(' ', $title);
            new $controller($page, strtolower(array_pop($e)));
        } else {
            new $controller($page);
        }

        if ($widget === 'postswidget') {
            new \ABirkett\controllers\PostsWidgetController($page);
        }

        if ($widget === 'twitterwidget') {
            new \ABirkett\controllers\TwitterWidgetController($page);
        }

        if ($widget === 'userwidget') {
            new \ABirkett\controllers\AdminUserWidgetController($page);
        }

        echo $page;

    }//end __construct()
}//end class
