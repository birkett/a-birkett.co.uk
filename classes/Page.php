<?php
//-----------------------------------------------------------------------------
// Page class
//
//  Builds pages using a template.
//-----------------------------------------------------------------------------
namespace ABirkett\classes;

class Page
{
    //-----------------------------------------------------------------------------
    // Constructor
    //-----------------------------------------------------------------------------
    public function __construct($title, $widget, $template)
    {
        $te = \ABirkett\TemplateEngine();

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
