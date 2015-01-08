<?php
//-----------------------------------------------------------------------------
// General site functions.
//
//  !!!This file should contain only functions needed to display the public
//		page. All admin related functions should be separate !!!
//-----------------------------------------------------------------------------
namespace ABirkett;

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
        $db = new PDOMySQLDatabase();
    }
    return $db;
}

//-----------------------------------------------------------------------------
// Open a TemplateEngine handle
//		In: none
//		Out: TemplateEngine object
//-----------------------------------------------------------------------------
function TemplateEngine()
{
    static $te = null;
    if (!isset($te)) {
        $te = new TemplateEngine();
    }
    return $te;
}

//-----------------------------------------------------------------------------
// Autoloader for Classes and Controllers
//		In: Class name
//		Out: none
//-----------------------------------------------------------------------------
function Autoloader($class)
{
    $prefix = 'ABirkett\\';

    //Does the class use this namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);

    $base_dir = __DIR__ . "/";
    if (strpos($class, "Controller")) {
        $folder = 'controllers/';
    } else {
        $folder = 'classes/';
    }

    $endpath = $folder . str_replace('\\', '/', $relative_class) . '.php';
    $file = $base_dir . $endpath;

    //Try the public folders
    if (file_exists($file)) {
        require $file;
        return;
    }

    //Try the admin folder
    if (defined('ADMINPAGE')) {
        $base_dir .= ADMIN_FOLDER;

        $file = $base_dir . $endpath;
        if (file_exists($file)) {
            require $file;
        }
    }
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

    //Autoloader
    spl_autoload_register("ABirkett\Autoloader");
}

//-----------------------------------------------------------------------------
// Define a symbol so public functions can act accordingly on an admin page
//      In: none
//      Out: none
//-----------------------------------------------------------------------------
function DeclareAdminPage()
{
    define('ADMINPAGE', 1);
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
            "SELECT * FROM blog_posts WHERE post_id = :id " . ($drafts ? "" : "AND post_draft='0' "),
            array(":id" => $id)
        );
    }
    $drafts ? $draftsql = "" : $draftsql = "WHERE post_draft='0' ";
    //Range of Posts
    if ($mode == "page") {
        $limit1 = $id * BLOG_POSTS_PER_PAGE;
        $limit2 = BLOG_POSTS_PER_PAGE;
        return GetDatabase()->runQuery(
            "SELECT * FROM blog_posts " . $draftsql . "ORDER BY post_timestamp DESC LIMIT $limit1,$limit2",
            array()
        );
    }
    //All posts - only fetch the ID, title, timestamp and Draft status to save query time
    if ($mode == "all") {
        return GetDatabase()->runQuery(
            "SELECT post_id, post_timestamp, post_title, post_draft FROM blog_posts " .
            $draftsql . "ORDER BY post_timestamp DESC",
            array()
        );
    }
}

//-----------------------------------------------------------------------------
// Get the base URL of the side (Protocol+DomainName+Backslash)
//		In: Raw string
//		Out: Safe string with original slashes removed - then escaped
//-----------------------------------------------------------------------------
function GetBaseURL()
{
    (stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true) ? $proto = "https://" : $proto = "http://";
    return $proto . $_SERVER['HTTP_HOST'] . "/";
}
