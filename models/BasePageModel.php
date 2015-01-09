<?php
//-----------------------------------------------------------------------------
// Basic page data
//-----------------------------------------------------------------------------
namespace ABirkett\models;

class BasePageModel
{
    //-----------------------------------------------------------------------------
    // Get the base URL of the side (Protocol+DomainName+Backslash)
    //		In: Raw string
    //		Out: Safe string with original slashes removed - then escaped
    //-----------------------------------------------------------------------------
    public function getBaseURL()
    {
        (stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true) ? $proto = "https://" : $proto = "http://";
        return $proto . $_SERVER['HTTP_HOST'] . "/";
    }
}
