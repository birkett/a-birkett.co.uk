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
    public function __construct(&$output)
    {
        $tags = [
            "{BASEURL}" => GetBaseURL(),
            "{RAND2551}" => rand(0, 255),
            "{RAND2552}" => rand(0, 255),
            "{RAND2553}" => rand(0, 255),
            "{RAND12}" => rand(1, 2),
            "{THISYEAR}" => date('Y'),
            "{ADMINFOLDER}" => ""
        ];
        TemplateEngine()->parseTags($tags, $output);

        if (CHRISTMAS) {
            $tags = [ "{EXTRASTYLESHEETS}", "{/EXTRASTYLESHEETS}" ];
            TemplateEngine()->removeTags($tags, $output);
        } else {
            TemplateEngine()->removeLogicTag("{EXTRASTYLESHEETS}", "{/EXTRASTYLESHEETS}", $output);
        }
        TemplateEngine()->removeLogicTag("{ADMINSTYLESHEET}", "{/ADMINSTYLESHEET}", $output);
    }
}
