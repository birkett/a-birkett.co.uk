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
        $result = GetAllPages();
        while (list($id, $title) = GetDatabase()->getRow($result)) {
            $tags = [
                "{PAGEID}" => $id,
                "{PAGETITLE}" => $title
            ];
            $temp = LogicTag("{LOOP}", "{/LOOP}", $output);
            ParseTags($tags, $temp);
            $temp .= "\n{LOOP}";
            ReplaceTag("{LOOP}", $temp, $output);
        }
        RemoveLogicTag("{LOOP}", "{/LOOP}", $output);

        parent::__construct($output);
    }
}
