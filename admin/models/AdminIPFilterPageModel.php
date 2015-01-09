<?php
//-----------------------------------------------------------------------------
// IP filter page data
//-----------------------------------------------------------------------------
namespace ABirkett\models;

class AdminIPFilterPageModel
{
    //-----------------------------------------------------------------------------
    // Gets all blocked IP addresses
    //      In: none
    //      Out: MySQLi result resource
    //-----------------------------------------------------------------------------
    public function getBlockedAddresses()
    {
        return \ABirkett\GetDatabase()->runQuery("SELECT * FROM blocked_addresses ORDER BY blocked_timestamp DESC", array());
    }
}
