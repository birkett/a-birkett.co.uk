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
	static $db = NULL;
	if(!isset($db))	{ $db = new Database(DATABASE_NAME); }
	return $db;
}

//-----------------------------------------------------------------------------
// Fetch the specified post or range of posts
//		In: Mode, ID and Draft lock
//		Out: Post data
//
//		Mode should be one of "single", "page" or "titles"
// !!! Defaults to not fetching drafts !!!
//-----------------------------------------------------------------------------
function GetPosts($mode, $id, $drafts = false)
{
	if($mode == "single") //Single post
		return GetDatabase()->RunQuery("SELECT * FROM blog_posts WHERE post_id = $id" . ($drafts ? " " : " AND post_draft='0' "));
	
	if($mode == "page") //Range of posts
	{
		$limit1 = $id * BLOG_POSTS_PER_PAGE;
		$limit2 = BLOG_POSTS_PER_PAGE;
		return GetDatabase()->RunQuery("SELECT * FROM blog_posts" . ($drafts ? " " : " WHERE post_draft='0' ") . "ORDER BY post_timestamp DESC LIMIT $limit1,$limit2");
	}
	
	if($mode == "all") //All posts - only fetch the ID, title, timestamp and Draft status to save query time
		return GetDatabase()->RunQuery("SELECT post_id, post_timestamp, post_title, post_draft FROM blog_posts" . ($drafts ? " " : " WHERE post_draft='0' ") . "ORDER BY post_timestamp DESC");
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
	return $db->GetNumRows($db->RunQuery("SELECT post_id from blog_posts" . ($drafts ? " " : " WHERE post_draft='0' ")));
}

//-----------------------------------------------------------------------------
// Fetch the comments for specified post ID
//		In: Post ID
//		Out: All comments for post 
//			(number can be fetched with GetNumberOfComments(n)
//-----------------------------------------------------------------------------
function GetCommentsOnPost($postid)
{
	return GetDatabase()->RunQuery("SELECT * FROM blog_comments WHERE post_id = $postid ORDER BY comment_timestamp ASC ");
}

//-----------------------------------------------------------------------------
// Get the total comments on a specified post
//		In: Post ID
//		Out: Number of comments on specified post
//-----------------------------------------------------------------------------
function GetNumberOfComments($postid)
{
	$db = GetDatabase();
	return $db->GetNumRows($db->RunQuery("SELECT comment_id from blog_comments WHERE post_id='$postid'"));
}

//-----------------------------------------------------------------------------
// Post a new comment to the database
//		In: Target post ID, Username, Text and IP address
//		Out: none
//-----------------------------------------------------------------------------
function PostComment($postid, $username, $comment, $clientip)
{
	$currenttime = time();
	GetDatabase()->RunQuery("INSERT INTO blog_comments(post_id, comment_username, comment_text, comment_timestamp, client_ip) VALUES('$postid', '$username', '$comment', '$currenttime', '$clientip')");
}

//-----------------------------------------------------------------------------
// Fetch page content by ID or Name
//		In: Page name or ID
//		Out: Page title and content or NULL
//-----------------------------------------------------------------------------
function GetPage($pagename)
{
	$db = GetDatabase();
	return $db->GetRow($db->RunQuery("SELECT page_title, page_content FROM site_pages WHERE " . (is_numeric($pagename) ? "page_id='$pagename'" : "page_name='$pagename'")));
}

//-----------------------------------------------------------------------------
// Checks if an IP is blocked
//		In: IP address
//		Out: TRUE on blocked, FALSE on not found
//-----------------------------------------------------------------------------
function CheckIP($ip)
{
	$db = GetDatabase();
	if($db->GetNumRows($db->RunQuery("SELECT * FROM blocked_addresses WHERE address='$ip'")) != 0)
		return true;
	return false;
}

//-----------------------------------------------------------------------------
// Make user input strings safe for the database
//		In: Raw string
//		Out: Safe string with original slashes removed - then escaped
//-----------------------------------------------------------------------------
function Sanitize($string)
{
	return GetDatabase()->EscapeString(stripslashes($string));
}

//-----------------------------------------------------------------------------
// Good, Bad and Blocked request exits
//		In: none
//		Out: Exits script with a response code, printing an optional message
//-----------------------------------------------------------------------------
function GoodRequest($m = "")    { echo $m; http_response_code(200); exit(); }
function BadRequest($m = "")     { echo $m; http_response_code(400); exit(); }
function BlockedRequest($m = "") { echo $m; http_response_code(401); exit(); }
?>