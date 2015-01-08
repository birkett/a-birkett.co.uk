<?php
//-----------------------------------------------------------------------------
// Admin functions.
//
//  !!!These are generally more risky than the front end functions. Hence
//      the separation!!!
//-----------------------------------------------------------------------------
namespace ABirkett;

//-----------------------------------------------------------------------------
// Check if the given username and password is valid
//      In: Username and Password
//      Out: TRUE on valid, FALSE on no match
//-----------------------------------------------------------------------------
function CheckCredentials($username, $password)
{
    $db = GetDatabase();
    $result = $db->runQuery(
        "SELECT password FROM site_users WHERE username = :username",
        array(":username" => $username)
    );

    if ($db->getNumRows($result) == 1) {
        $dbhash = $db->getRow($result);
        if (password_verify($password, $dbhash[0])) {
            $_SESSION['user'] = $username;
            return true;
        }
    }
    return false;
}

//-----------------------------------------------------------------------------
// Check if a user is logged in with a valid session
//      In: none
//      Out: TRUE on logged in, FALSE if not
//-----------------------------------------------------------------------------
function IsLoggedIn()
{
    if (isset($_SESSION['user'])) {
        return true;
    } else {
        return false;
    }
}

//-----------------------------------------------------------------------------
// Destroys a user session - causing a logout
//      In: none
//      Out: none
//-----------------------------------------------------------------------------
function KillSession()
{
    if (isset($_SESSION['user'])) {
        unset($_SESSION['user']);
        session_destroy();
    }
}

//-----------------------------------------------------------------------------
// Helper to convert boolean (yes/no) to integer (1/0)
//      In: Boolean value
//      Out: Integer equivalent
//-----------------------------------------------------------------------------
function BoolToInt($bool)
{
    if ($bool == "true") {
        return 1;
    } else {
        return 0;
    }
}

//-----------------------------------------------------------------------------
// Fetch ID and Title of all pages
//      In: none
//      Out: All page IDs and Titles as MySQLi result resource
//-----------------------------------------------------------------------------
function GetAllPages()
{
    return GetDatabase()->runQuery("SELECT page_id, page_title from site_pages", array());
}

//-----------------------------------------------------------------------------
// Update a given post
//      In: ID, Title, Content, Draft
//      Out: none
//-----------------------------------------------------------------------------
function UpdatePost($postid, $title, $content, $draft)
{
    $draft = BoolToInt($draft);
    GetDatabase()->runQuery(
        "UPDATE blog_posts SET post_title = :title, post_content = :content, " .
        "post_draft = :draft WHERE post_id = :postid LIMIT 1",
        array(":title" => $title, ":content" => $content, ":draft" => $draft, ":postid" => $postid)
    );
    TweetPost($postid);
}

//-----------------------------------------------------------------------------
// Update a given page
//      In: ID, Content
//      Out: none
//-----------------------------------------------------------------------------
function UpdatePage($pageid, $content)
{
    GetDatabase()->runQuery(
        "UPDATE site_pages SET page_content = :content WHERE page_id = :pageid LIMIT 1",
        array(":content" => $content, ":pageid" => $pageid)
    );
}

//-----------------------------------------------------------------------------
// Create a new post
//      In: Title, Content, Draft
//      Out: none
//-----------------------------------------------------------------------------
function NewPost($title, $content, $draft)
{
    $db = GetDatabase();
    $draft = BoolToInt($draft);
    $db->runQuery(
        "INSERT INTO blog_posts(post_timestamp, post_title, post_content, post_draft, post_tweeted) " .
        "VALUES(:timestamp, :title, :content, :draft, 0)",
        array(":timestamp" => time(), ":title" => $title, ":content" => $content, ":draft" => $draft)
    );
    $data = $db->runQuery("SELECT post_id FROM blog_posts ORDER BY post_timestamp DESC LIMIT 1", array());
    $row = $db->getRow($data);
    TweetPost($row[0]); //Tweet this if not already done
}

//-----------------------------------------------------------------------------
// Blocks an IP address
//      In: IP Address
//      Out: none
//-----------------------------------------------------------------------------
function BlockIP($ip)
{
    if (CheckIP($ip)) {
        return; //do nothing if already blocked
    }
    GetDatabase()->runQuery(
        "INSERT INTO blocked_addresses(address, blocked_timestamp) VALUES(:ip, :timestamp)",
        array(":ip" => $ip, ":timestamp" => time())
    );
}

//-----------------------------------------------------------------------------
// Unblocks an IP address
//      In: IP Address
//      Out: none
//-----------------------------------------------------------------------------
function UnblockIP($ip)
{
    GetDatabase()->runQuery("DELETE FROM blocked_addresses WHERE address = :ip", array(":ip" => $ip));
}

//-----------------------------------------------------------------------------
// Gets all blocked IP addresses
//      In: none
//      Out: MySQLi result resource
//-----------------------------------------------------------------------------
function GetBlockedAddresses()
{
    return GetDatabase()->runQuery("SELECT * FROM blocked_addresses ORDER BY blocked_timestamp DESC", array());
}

//-----------------------------------------------------------------------------
// Fetch all comments
//      In: Optional IP Address
//      Out: All comment data
//-----------------------------------------------------------------------------
function GetAllComments($ip = "")
{
    return GetDatabase()->runQuery(
        "SELECT * FROM blog_comments" . ($ip == "" ? " " : " WHERE client_ip='$ip' ") .
        "ORDER BY comment_timestamp DESC",
        array()
    );
}

//-----------------------------------------------------------------------------
// Securely hash a password (not reversible)
//      In: Plain text password
//      Out: Hashed password
// This uses a random salt for extra security
//-----------------------------------------------------------------------------
function HashPassword($password)
{
    $options = [
        'cost' => 10,
    ];
    return password_hash($password, PASSWORD_BCRYPT, $options);
}

//-----------------------------------------------------------------------------
// Changes the admin password
//      In: Current password, New password and New password again (confirm)
//      Out: none
//-----------------------------------------------------------------------------
function ChangePassword($currentpassword, $newpassword, $confirmedpassword)
{
    if ($newpassword != $confirmedpassword) {
        return false; //Passwords dont match
    }
    $db = GetDatabase();
    $data = $db->runQuery("SELECT username FROM site_users WHERE user_id='1'", array());
    $row = $db->getRow($data);

    if (!CheckCredentials($row[0], $currentpassword)) {
        return false; //Current password is wrong
    }
    $hash = HashPassword($newpassword);

    $db->runQuery("UPDATE site_users SET password='$hash' WHERE user_id='1'", array());
    return true;
}

//-----------------------------------------------------------------------------
// Send a tweet about a specified post
//      In: Post ID
//      Out: none
//-----------------------------------------------------------------------------
function TweetPost($postid)
{
    $db = GetDatabase();
    $post = getPosts("single", $postid, false);
    if ($db->GetNumRows($post) == 0) {
        return; //Post doesnt exist or is a draft
    }
    list($id, $timestamp, $title, $content, $draft, $post_tweeted) = $db->getRow($post);
    if ($post_tweeted == 1) {
        return; //Already tweeted out
    }

    GetBaseURL();
    $url = GetBaseURL() . "blog/" . $id;

    $tweet = "New Blog Post: " . $title . " - " . $url;

    $twitter = new TwitterOAuth(
        TWITTER_CONSUMER_KEY,
        TWITTER_CONSUMER_SECRET,
        TWITTER_OAUTH_TOKEN,
        TWITTER_OAUTH_SECRET
    );
    $twitter->post('statuses/update', array('status' => $tweet));

    $db->runQuery("UPDATE blog_posts SET post_tweeted=1 WHERE post_id = :postid", array(":postid" => $postid));
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
