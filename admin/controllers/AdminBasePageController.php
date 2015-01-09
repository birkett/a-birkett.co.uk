<?php
//-----------------------------------------------------------------------------
// Parse essential tags in the admin basic page template
//      In: Unparsed template
//      Out: Parsed template
//
//  !!! All pages get parsed through here !!!
//-----------------------------------------------------------------------------
namespace ABirkett\controllers;

class AdminBasePageController extends BasePageController
{
    public function __construct(&$output)
    {
        $te = \ABirkett\TemplateEngine();
        $tags = [
            "{ADMINFOLDER}" => ADMIN_FOLDER,
        ];
        $te->parseTags($tags, $output);

        $tags = [ "{ADMINSTYLESHEET}", "{/ADMINSTYLESHEET}" ];
        $te->removeTags($tags, $output);

        parent::__construct($output);
    }
}
