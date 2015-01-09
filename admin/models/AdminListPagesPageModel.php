<?php
//-----------------------------------------------------------------------------
// List Pages page data
//-----------------------------------------------------------------------------
namespace ABirkett\models;

class AdminListPagesPageModel
{
    //-----------------------------------------------------------------------------
    // Fetch ID and Title of all pages
    //      In: none
    //      Out: All page IDs and Titles as MySQLi result resource
    //-----------------------------------------------------------------------------
    public function getAllPages()
    {
        return \ABirkett\GetDatabase()->runQuery("SELECT page_id, page_title from site_pages", array());
    }
}
