<?php
//-----------------------------------------------------------------------------
// Build a generic page stored in the database
//      In: Unparsed template
//      Out: Parsed template
//
//  !!! This controller is only used for pages stored in the database !!!
//-----------------------------------------------------------------------------
namespace ABirkett;

class GenericPageController
{
    public function __construct(&$output, $name)
    {
        $page = GetPage($name);
        $tags = [
            "{PAGETITLE}" => $page[0],
            "{PAGECONTENT}" => stripslashes($page[1])
        ];
        ParseTags($tags, $output);
    }
}
