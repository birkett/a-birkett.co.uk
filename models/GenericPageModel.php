<?php
//-----------------------------------------------------------------------------
// Generic page data
//-----------------------------------------------------------------------------
namespace ABirkett\models;

class GenericPageModel
{
    //-----------------------------------------------------------------------------
    // Fetch page content
    //		In: Page name
    //		Out: Page title and content
    //-----------------------------------------------------------------------------
    public function getPage($pagename)
    {
        $page = \ABirkett\GetDatabase()->runQuery(
            "SELECT page_title, page_content FROM site_pages WHERE page_name = :pagename",
            array(":pagename" => $pagename)
        );
        return $page[0];
    }
}
