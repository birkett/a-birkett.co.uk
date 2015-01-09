<?php
/**
* Serves GET request by serving a page
*
* PHP Version 5.5
*
* @category Classes
* @package  PersonalWebsite
* @author   Anthony Birkett <anthony@a-birkett.co.uk>
* @license  http://opensource.org/licenses/MIT MIT
* @link     http://www.a-birkett.co.uk
*/
namespace ABirkett\classes;

class Page
{
    /**
    * Generate a page
    * @param string $title    Page title
    * @param string $widget   Request widget
    * @param string $template Requested template
    * @return none
    */
    public function __construct($title, $widget, $template)
    {
        $te = \ABirkett\classes\TemplateEngine::getInstance();

        if ($template == "feed") {
            $pagetemplate = $te->loadPageTemplate("feed.tpl");
            $tags = [ "{TITLE}" => $title ];
        } else {
            $pagetemplate = $te->loadPageTemplate("page.tpl");

            $tags = [
                "{PAGE}" => $te->loadSubTemplate("$template.tpl"),
                "{WIDGET}" => $te->loadSubTemplate("$widget.tpl"),
                "{TITLE}" => $title
            ];
        }
        $te->parseTags($tags, $pagetemplate);

        if (defined('ADMINPAGE')) {
            switch ($template) {
                case "listcomments":
                    new \ABirkett\controllers\AdminListCommentsPageController($pagetemplate);
                    break;
                case "listposts":
                    new \ABirkett\controllers\AdminListPostsPageController($pagetemplate);
                    break;
                case "listpages":
                    new \ABirkett\controllers\AdminListPagesPageController($pagetemplate);
                    break;
                case "serverinfo":
                    new \ABirkett\controllers\AdminServerInfoPageController($pagetemplate);
                    break;
                case "ipfilter":
                    new \ABirkett\controllers\AdminIPFilterPageController($pagetemplate);
                    break;
                case "edit":
                    new \ABirkett\controllers\AdminEditPageController($pagetemplate);
                    break;
                default:
                    new \ABirkett\controllers\AdminBasePageController($pagetemplate);
            }
            if ($widget = "userwidget") {
                new \ABirkett\controllers\AdminUserWidgetController($pagetemplate);
            }
        } else {
            switch ($template) {
                case "generic":
                    $e = explode(' ', $title);  //Get page name from last word of title
                    new \ABirkett\controllers\GenericPageController($pagetemplate, strtolower(array_pop($e)));
                    break;
                case "blog":
                    new \ABirkett\controllers\BlogPageController($pagetemplate);
                    break;
                case "feed":
                    new \ABirkett\controllers\FeedPageController($pagetemplate);
                    break;
                default:
                    new \ABirkett\controllers\BasePageController($pagetemplate);
            }
            if ($widget == "postswidget") {
                new \ABirkett\controllers\PostsWidgetController($pagetemplate);
            }
        }
        echo $pagetemplate;
    }
}
