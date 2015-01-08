<?php
//-----------------------------------------------------------------------------
// Build the admin side widget
//      In: Unparsed template
//      Out: Parsed template
//-----------------------------------------------------------------------------
namespace ABirkett;

class AdminUserWidgetController extends AdminBasePageController
{
    public function __construct(&$output)
    {
        if (isset($_SESSION['user'])) {
            RemoveLogicTag("{LOGIN}", "{/LOGIN}", $output);
            ReplaceTag("{USERNAME}", $_SESSION['user'], $output);
        } else {
            RemoveLogicTag("{LOGGEDIN}", "{/LOGGEDIN}", $output);
        }
        $cleantags = [ "{LOGIN}", "{/LOGIN}", "{LOGGEDIN}", "{/LOGGEDIN}" ];
        RemoveTags($cleantags, $output);

        parent::__construct($output);
    }
}
