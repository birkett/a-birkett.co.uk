<?php
//-----------------------------------------------------------------------------
// Build the listpages page
//      In: Unparsed template
//      Out: Parsed template
//-----------------------------------------------------------------------------
namespace ABirkett;

class AdminListPagesPageController extends AdminBasePageController
{
    public function __construct(&$output)
    {
        $te = TemplateEngine();
        $result = GetAllPages();
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
