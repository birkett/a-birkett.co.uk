<?php
//-----------------------------------------------------------------------------
// General site functions. 
//
//  !!!This file should contain only functions needed to display the public 
//		page. All admin related functions should be separate !!!
//-----------------------------------------------------------------------------

//-----------------------------------------------------------------------------
// Open a database handle
//		In: none
//		Out: Database object
//  Store the current database object to prevent multiple connections
//-----------------------------------------------------------------------------
function GetDatabase()
{
    static $db = null;
    if (!isset($db)) {
        if (extension_loaded("PDO_MySQL")) {
            $db = new ABirkett\PDOMySQLDatabase();
        } elseif (extension_loaded("MySQLi")) {
            $db = new ABirkett\MySQLiDatabase();
        } else {
            die("No database driver available.");
        }
    }
    return $db;
}

//-----------------------------------------------------------------------------
// Set up PHP with some new defaults
//		In: none
//		Out: none
//-----------------------------------------------------------------------------
function PHPDefaults()
{
    //Show PHP errors and warnings
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    //Timezone for converting timestamps
    date_default_timezone_set("Europe/London");
}

//-----------------------------------------------------------------------------
// Open a template file for inclusion
//		In: Filename
//		Out: Unparsed (sub)template
//-----------------------------------------------------------------------------
function OpenTemplate($file)
{
    return file_get_contents(TEMPLATE_FOLDER . $file);
}

//-----------------------------------------------------------------------------
// Replace a tag with a string (for inserting sub templates into the output)
//		In: Tag and parsed sub template
//		Out: Parsed template
//-----------------------------------------------------------------------------
function ReplaceTag($tag, $string, &$output)
{
    $output = str_replace($tag, $string, $output);
}

//-----------------------------------------------------------------------------
// Parse the tags in a given array to the template
//		In: Tags and Unparsed template
//		Out: Parsed template
//-----------------------------------------------------------------------------
function ParseTags(&$tags, &$output)
{
    foreach ($tags as $key => $val) {
        ReplaceTag($key, $val, $output);
    }
}

//-----------------------------------------------------------------------------
// Remove any left over tags from the parsed template
//		In: Tags and Parsed template
//		Out: Clean Parsed template
//-----------------------------------------------------------------------------
function RemoveTags(&$tags, &$output)
{
    foreach ($tags as $tag) {
        ReplaceTag($tag, "", $output);
    }
}

//-----------------------------------------------------------------------------
// Parse logic tags to the template
//		In: Tags and Unparsed template
//		Out: Parsed template
//
//  Logic tags can be loops, i.e. {LOOP} content {/LOOP}
//-----------------------------------------------------------------------------
function LogicTag($start, $end, &$content)
{
    $r = explode($start, $content);
    if (isset($r[1])) {
        $r = explode($end, $r[1]);
        return $r[0];
    }
    return '';
}

//-----------------------------------------------------------------------------
// Remove any left over logic tags from the parsed template
//		In: Tags and Parsed template
//		Out: Clean Parsed template
//-----------------------------------------------------------------------------
function RemoveLogicTag($start, $end, &$content)
{
    $beginningPos = strpos($content, $start);
    $endPos = strpos($content, $end);
    if (!$beginningPos || !$endPos) {
        return;
    }
    $textToDelete = substr($content, $beginningPos, ($endPos + strlen($end)) - $beginningPos);
    $content = str_replace($textToDelete, '', $content);
}

//-----------------------------------------------------------------------------
// Fetch the specified post or range of posts
//		In: Mode, ID and Draft lock
//		Out: Post data
//
//		Mode should be one of "single", "page" or "titles"
// !!! Defaults to not fetching drafts !!!
//-----------------------------------------------------------------------------
function GetPosts($mode, $id = 0, $drafts = false)
{
    //Single Post
    if ($mode == "single") {
        return GetDatabase()->runQuery(
            "SELECT * FROM blog_posts WHERE post_id = $id " . ($drafts ? "" : "AND post_draft='0' ")
        );
    }
    $drafts ? $draftsql = "" : $draftsql = "WHERE post_draft='0' ";
    //Range of Posts
    if ($mode == "page") {
        $limit1 = $id * BLOG_POSTS_PER_PAGE;
        $limit2 = BLOG_POSTS_PER_PAGE;
        return GetDatabase()->runQuery(
            "SELECT * FROM blog_posts " . $draftsql . "ORDER BY post_timestamp DESC LIMIT $limit1,$limit2"
        );
    }
    //All posts - only fetch the ID, title, timestamp and Draft status to save query time
    if ($mode == "all") {
        return GetDatabase()->runQuery(
            "SELECT post_id, post_timestamp, post_title, post_draft FROM blog_posts " .
            $draftsql . "ORDER BY post_timestamp DESC"
        );
    }
}

//-----------------------------------------------------------------------------
// Get the total number of blog posts
//		In: none
//		Out: Number of posts
// !!! Defaults to not displaying drafts !!!
//-----------------------------------------------------------------------------
function GetNumberOfPosts($drafts = false)
{
    $db = GetDatabase();
    return $db->getNumRows(
        $db->runQuery(
            "SELECT post_id from blog_posts " . ($drafts ? "" : "WHERE post_draft='0' ")
        )
    );
}

//-----------------------------------------------------------------------------
// Fetch the comments for specified post ID
//		In: Post ID
//		Out: All comments for post 
//			(number can be fetched with GetNumberOfComments(n)
//-----------------------------------------------------------------------------
function GetCommentsOnPost($postid)
{
    return GetDatabase()->runQuery(
        "SELECT * FROM blog_comments WHERE post_id = $postid ORDER BY comment_timestamp ASC "
    );
}

//-----------------------------------------------------------------------------
// Get the total comments on a specified post
//		In: Post ID
//		Out: Number of comments on specified post
//-----------------------------------------------------------------------------
function GetNumberOfComments($postid)
{
    $db = GetDatabase();
    return $db->getNumRows($db->runQuery("SELECT comment_id from blog_comments WHERE post_id='$postid'"));
}

//-----------------------------------------------------------------------------
// Post a new comment to the database
//		In: Target post ID, Username, Text and IP address
//		Out: none
//-----------------------------------------------------------------------------
function PostComment($postid, $username, $comment, $clientip)
{
    $currenttime = time();
    GetDatabase()->runQuery(
        "INSERT INTO blog_comments(post_id, comment_username, comment_text, comment_timestamp, client_ip)" .
        " VALUES('$postid', $username, $comment, $currenttime, '$clientip')"
    );
}

//-----------------------------------------------------------------------------
// Fetch page content by ID or Name
//		In: Page name or ID
//		Out: Page title and content or NULL
//-----------------------------------------------------------------------------
function GetPage($pagename)
{
    $db = GetDatabase();
    return $db->getRow(
        $db->runQuery(
            "SELECT page_title, page_content FROM site_pages WHERE " .
            (is_numeric($pagename) ? "page_id='$pagename'" : "page_name='$pagename'")
        )
    );
}

//-----------------------------------------------------------------------------
// Checks if an IP is blocked
//		In: IP address
//		Out: TRUE on blocked, FALSE on not found
//-----------------------------------------------------------------------------
function CheckIP($ip)
{
    $db = GetDatabase();
    if ($db->getNumRows($db->runQuery("SELECT * FROM blocked_addresses WHERE address='$ip'")) != 0) {
        return true;
    }
    return false;
}

//-----------------------------------------------------------------------------
// Make user input strings safe for the database
//		In: Raw string
//		Out: Safe string with original slashes removed - then escaped
//-----------------------------------------------------------------------------
function Sanitize($string)
{
    return GetDatabase()->escapeString(stripslashes($string));
}

//-----------------------------------------------------------------------------
// Good, Bad and Blocked request exits
//		In: none
//		Out: Exits script with a response code, printing an optional message
//-----------------------------------------------------------------------------
function GoodRequest($m = "")
{
    echo $m;
    http_response_code(200);
    exit();
}

function BadRequest($m = "")
{
    echo $m;
    http_response_code(400);
    exit();
}

function BlockedRequest($m = "")
{
    echo $m;
    http_response_code(401);
    exit();
}
