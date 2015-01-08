<?php
//-----------------------------------------------------------------------------
// Parse essential tags in the admin basic page template
//      In: Unparsed template
//      Out: Parsed template
//
//  !!! All pages get parsed through here !!!
//-----------------------------------------------------------------------------
namespace ABirkett;

class AdminBasePageController extends BasePageController
{
    public function __construct(&$output)
    {
        $te = TemplateEngine();
        $tags = [
            "{ADMINFOLDER}" => ADMIN_FOLDER,
        ];
        $te->parseTags($tags, $output);

        $tags = [ "{ADMINSTYLESHEET}", "{/ADMINSTYLESHEET}" ];
        $te->removeTags($tags, $output);

        parent::__construct($output);
    }
}
