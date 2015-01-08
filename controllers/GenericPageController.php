<?php
//-----------------------------------------------------------------------------
// Build a generic page stored in the database
//      In: Unparsed template
//      Out: Parsed template
//
//  !!! This controller is only used for pages stored in the database !!!
//-----------------------------------------------------------------------------
namespace ABirkett;

class GenericPageController extends BasePageController
{
    //-----------------------------------------------------------------------------
    // Fetch page content
    //		In: Page name
    //		Out: Page title and content
    //-----------------------------------------------------------------------------
    private function getPage($pagename)
    {
        $page = GetDatabase()->runQuery(
            "SELECT page_title, page_content FROM site_pages WHERE page_name = :pagename",
            array(":pagename" => $pagename)
        );
        return $page[0];
    }

    public function __construct(&$output, $name)
    {
        $page = $this->getPage($name);
        $tags = [
            "{PAGETITLE}" => $page['page_title'],
            "{PAGECONTENT}" => stripslashes($page['page_content'])
        ];
        TemplateEngine()->parseTags($tags, $output);
        parent::__construct($output);
    }
}
