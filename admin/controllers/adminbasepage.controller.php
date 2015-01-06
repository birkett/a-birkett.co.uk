<?php
//-----------------------------------------------------------------------------
// Parse essential tags in the admin basic page template
//      In: Unparsed template
//      Out: Parsed template
//
//  !!! All pages get parsed through here !!!
//-----------------------------------------------------------------------------
namespace ABirkett;

class AdminBasePageController
{
    public function __construct(&$output)
    {
        $tags = [
            "{ADMINFOLDER}" => ADMIN_FOLDER,
        ];
        ParseTags($tags, $output);
        
        $tags = [ "{ADMINSTYLESHEET}", "{/ADMINSTYLESHEET}" ];
        RemoveTags($tags, $output);
    }
}
