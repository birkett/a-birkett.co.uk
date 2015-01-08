<?php
//-----------------------------------------------------------------------------
// Build the ipfilter page
//      In: Unparsed template
//      Out: Parsed template
//-----------------------------------------------------------------------------
namespace ABirkett;

class AdminIPFilterPageController extends AdminBasePageController
{
    public function __construct(&$output)
    {
        $te = TemplateEngine();
        $result = GetBlockedAddresses();
        while (list($ip_id, $address, $timestamp) = GetDatabase()->GetRow($result)) {
            $tags = [
                "{IP}" => $address,
                "{TIMESTAMP}" => date(DATE_FORMAT, $timestamp)
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
