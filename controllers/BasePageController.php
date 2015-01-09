<?php
//-----------------------------------------------------------------------------
// Parse essential tags in the basic page template
//      In: Unparsed template
//      Out: Parsed template
//
//  !!! All pages get parsed through here !!!
//-----------------------------------------------------------------------------
namespace ABirkett\controllers;

class BasePageController
{
    public function __construct(&$output)
    {
        $te = \ABirkett\TemplateEngine();
        $tags = [
            "{BASEURL}" => \ABirkett\GetBaseURL(),
            "{RAND2551}" => rand(0, 255),
            "{RAND2552}" => rand(0, 255),
            "{RAND2553}" => rand(0, 255),
            "{RAND12}" => rand(1, 2),
            "{THISYEAR}" => date('Y'),
            "{ADMINFOLDER}" => ""
        ];
        $te->parseTags($tags, $output);

        if (CHRISTMAS) {
            $tags = [ "{EXTRASTYLESHEETS}", "{/EXTRASTYLESHEETS}" ];
            $te->removeTags($tags, $output);
        } else {
            $te->removeLogicTag("{EXTRASTYLESHEETS}", "{/EXTRASTYLESHEETS}", $output);
        }
        $te->removeLogicTag("{ADMINSTYLESHEET}", "{/ADMINSTYLESHEET}", $output);
    }
}
