<?php
//-----------------------------------------------------------------------------
// Build the ipfilter page
//      In: Unparsed template
//      Out: Parsed template
//-----------------------------------------------------------------------------
namespace ABirkett\controllers;

class AdminIPFilterPageController extends AdminBasePageController
{
    //-----------------------------------------------------------------------------
    // Gets all blocked IP addresses
    //      In: none
    //      Out: MySQLi result resource
    //-----------------------------------------------------------------------------
    private function getBlockedAddresses()
    {
        return \ABirkett\GetDatabase()->runQuery("SELECT * FROM blocked_addresses ORDER BY blocked_timestamp DESC", array());
    }

    public function __construct(&$output)
    {
        $te = \ABirkett\TemplateEngine();
        $result = $this->getBlockedAddresses();
        while (list($ip_id, $address, $timestamp) = \ABirkett\GetDatabase()->GetRow($result)) {
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
