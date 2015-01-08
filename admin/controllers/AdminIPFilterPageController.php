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
        $result = GetBlockedAddresses();
        while (list($ip_id, $address, $timestamp) = GetDatabase()->GetRow($result)) {
            $tags = [
                "{IP}" => $address,
                "{TIMESTAMP}" => date(DATE_FORMAT, $timestamp)
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
