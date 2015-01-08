<?php
//-----------------------------------------------------------------------------
// Build the listpages page
//      In: Unparsed template
//      Out: Parsed template
//-----------------------------------------------------------------------------
namespace ABirkett;

class AdminListPagesPageController extends AdminBasePageController
{
    //-----------------------------------------------------------------------------
    // Fetch ID and Title of all pages
    //      In: none
    //      Out: All page IDs and Titles as MySQLi result resource
    //-----------------------------------------------------------------------------
    function getAllPages()
    {
        return GetDatabase()->runQuery("SELECT page_id, page_title from site_pages", array());
    }
    
    public function __construct(&$output)
    {
        $te = TemplateEngine();
        $result = $this->getAllPages();
        while (list($id, $title) = GetDatabase()->getRow($result)) {
            $tags = [
                "{PAGEID}" => $id,
                "{PAGETITLE}" => $title
            ];
            $temp = $te->logicTag("{LOOP}", "{/LOOP}", $output);
            $te->parseTags($tags, $temp);
            $temp .= "\n{LOOP}";
            $te->replaceTag("{LOOP}", $temp, $output);
        }
        $te->removeLogicTag("{LOOP}", "{/LOOP}", $output);

        parent::__construct($output);
    }
}
