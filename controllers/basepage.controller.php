<?php
//-----------------------------------------------------------------------------
// Parse essential tags in the basic page template
//      In: Unparsed template
//      Out: Parsed template
//
//  !!! All pages get parsed through here !!!
//-----------------------------------------------------------------------------
namespace ABirkett;

class BasePageController
{
    public function __construct(&$output, $title)
    {
        (stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true) ? $proto = "https://" : $proto = "http://";
        $tags = [
            "{BASEURL}" => $proto . $_SERVER['HTTP_HOST'] . "/",
            "{TITLE}" => $title,
            "{RAND2551}" => rand(0, 255),
            "{RAND2552}" => rand(0, 255),
            "{RAND2553}" => rand(0, 255),
            "{RAND12}" => rand(1, 2),
            "{THISYEAR}" => date('Y'),
            "{ADMINFOLDER}" => ""
        ];
        ParseTags($tags, $output);
        
        if (CHRISTMAS) {
            $tags = [ "{EXTRASTYLESHEETS}", "{/EXTRASTYLESHEETS}" ];
            RemoveTags($tags, $output);
        } else {
            RemoveLogicTag("{EXTRASTYLESHEETS}", "{/EXTRASTYLESHEETS}", $output);
        }
        RemoveLogicTag("{ADMINSTYLESHEET}", "{/ADMINSTYLESHEET}", $output);
    }
}
