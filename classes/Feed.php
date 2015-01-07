<?php
//-----------------------------------------------------------------------------
// Feed class
//
//  Builds an XML feed using a template.
//-----------------------------------------------------------------------------
namespace ABirkett;

class Feed
{
    //-----------------------------------------------------------------------------
    // Constructor
    //-----------------------------------------------------------------------------
    public function __construct()
    {
        $pagetemplate = OpenTemplate("feed.tpl");

        new FeedPageController($pagetemplate);
        echo $pagetemplate;
    }
}
