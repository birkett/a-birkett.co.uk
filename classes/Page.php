<?php
//-----------------------------------------------------------------------------
// Page class
//
//  Builds pages using a template.
//-----------------------------------------------------------------------------
namespace ABirkett;

class Page
{
    //-----------------------------------------------------------------------------
    // Constructor
    //-----------------------------------------------------------------------------
    public function __construct($title, $widget, $template)
    {
        $te = TemplateEngine();

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
                    new AdminListCommentsPageController($pagetemplate);
                    break;
                case "listposts":
                    new AdminListPostsPageController($pagetemplate);
                    break;
                case "listpages":
                    new AdminListPagesPageController($pagetemplate);
                    break;
                case "serverinfo":
                    new AdminServerInfoPageController($pagetemplate);
                    break;
                case "ipfilter":
                    new AdminIPFilterPageController($pagetemplate);
                    break;
                case "edit":
                    new AdminEditPageController($pagetemplate);
                    break;
                default:
                    new AdminBasePageController($pagetemplate);
            }
            if ($widget = "userwidget") {
                new AdminUserWidgetController($pagetemplate);
            }
        } else {
            switch ($template) {
                case "generic":
                    $e = explode(' ', $title);  //Get page name from last word of title
                    new GenericPageController($pagetemplate, strtolower(array_pop($e)));
                    break;
                case "blog":
                    new BlogPageController($pagetemplate);
                    break;
                case "feed":
                    new FeedPageController($pagetemplate);
                    break;
                default:
                    new BasePageController($pagetemplate);
            }
            if ($widget == "postswidget") {
                new PostsWidgetController($pagetemplate);
            }
        }
        echo $pagetemplate;
    }
}
