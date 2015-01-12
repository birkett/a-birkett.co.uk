<?php
/**
* AdminIPFilterPageModel - glue between the database and Controller
*
* PHP Version 5.5
*
* @category AdminModels
* @package  PersonalWebsite
* @author   Anthony Birkett <anthony@a-birkett.co.uk>
* @license  http://opensource.org/licenses/MIT MIT
* @link     http://www.a-birkett.co.uk
*/
namespace ABirkett\models;

class AdminIPFilterPageModel extends AdminBasePageModel
{
    /**
     * Fetch a list of all blacklisted addresses
     * @return mixed[] Array of blacklist entries
     */
    public function getBlockedAddresses()
    {
        return $this->database->runQuery(
            "SELECT * FROM blocked_addresses ORDER BY blocked_timestamp DESC"
        );
    }
}
