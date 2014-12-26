<?php
//-----------------------------------------------------------------------------
// Admin functions. 
//
//  !!!These are generally more risky than the front end functions. Hence
//		the separation!!!
//-----------------------------------------------------------------------------


//-----------------------------------------------------------------------------
// Check if the given username and password is valid
//		In: Username and Password
//		Out: TRUE on valid, FALSE on no match
//-----------------------------------------------------------------------------
function CheckCredentials($username, $password)
{
	$db = GetDatabase();
	$result = $db->RunQuery("SELECT password FROM site_users WHERE username='$username'");
	
	if($db->GetNumRows($result) == 1) 
	{
		$dbhash = $db->GetRow($result);
		if(password_verify($password, $dbhash[0])) 
			return true;
	}
	return false;
}

//-----------------------------------------------------------------------------
// Check if a user is logged in with a valid session 
//		In: none
//		Out: TRUE on logged in, FALSE if not
//-----------------------------------------------------------------------------
function IsLoggedIn()
{
	isset($_SESSION['user']) ? $r = true : $r = false; return $r;
}

//-----------------------------------------------------------------------------
// Destroys a user session - causing a logout
//		In: none
//		Out: none
//-----------------------------------------------------------------------------
function KillSession()
{
	if(isset($_SESSION['user'])) 
	{
		unset($_SESSION['user']);
		session_destroy();
	}
}

//-----------------------------------------------------------------------------
// Helper to convert boolean (yes/no) to integer (1/0)
//		In: Boolean value
//		Out: Integer equivalent
//-----------------------------------------------------------------------------
function BoolToInt($bool)
{
	$bool == "true" ? $r = 1 : $r = 0; return $r;
}

//-----------------------------------------------------------------------------
// Fetch ID and Title of all pages
//		In: none
//		Out: All page IDs and Titles as MySQLi result resource
//-----------------------------------------------------------------------------
function GetAllPages()
{
	return GetDatabase()->RunQuery("SELECT page_id, page_title from site_pages");
}

//-----------------------------------------------------------------------------
// Update a given post
//		In: ID, Title, Content, Draft
//		Out: none
//-----------------------------------------------------------------------------
function UpdatePost($postid, $title, $content, $draft)
{
	$draft = BoolToInt($draft);
	GetDatabase()->RunQuery("UPDATE blog_posts SET post_title='$title', post_content='$content', post_draft='$draft' WHERE post_id='$postid' LIMIT 1");
}

//-----------------------------------------------------------------------------
// Update a given page
//		In: ID, Content
//		Out: none
//-----------------------------------------------------------------------------
function UpdatePage($pageid, $content)
{
	GetDatabase()->RunQuery("UPDATE site_pages SET page_content='$content' WHERE page_id='$pageid' LIMIT 1");
}

//-----------------------------------------------------------------------------
// Create a new post
//		In: Title, Content, Draft
//		Out: none
//-----------------------------------------------------------------------------
function NewPost($title, $content, $draft)
{
	$draft = BoolToInt($draft);
	$timestamp = time();
	GetDatabase()->RunQuery("INSERT INTO blog_posts(post_timestamp, post_title, post_content, post_draft) VALUES('$timestamp', '$title', '$content', '$draft')");
}

//-----------------------------------------------------------------------------
// Blocks an IP address
//		In: IP Address
//		Out: none
//-----------------------------------------------------------------------------
function BlockIP($ip)
{
	$timestamp = time();
	if(CheckIP($ip)) return; //do nothing if already blocked
	GetDatabase()->RunQuery("INSERT INTO blocked_addresses(address, blocked_timestamp) VALUES('$ip', '$timestamp')");
}

//-----------------------------------------------------------------------------
// Unblocks an IP address
//		In: IP Address
//		Out: none
//-----------------------------------------------------------------------------
function UnblockIP($ip)
{
	GetDatabase()->RunQuery("DELETE FROM blocked_addresses WHERE address='$ip'");
}

//-----------------------------------------------------------------------------
// Gets all blocked IP addresses
//		In: none
//		Out: MySQLi result resource
//-----------------------------------------------------------------------------
function GetBlockedAddresses()
{
	return GetDatabase()->RunQuery("SELECT * FROM blocked_addresses ORDER BY blocked_timestamp DESC");
}

//-----------------------------------------------------------------------------
// Fetch all comments
//		In: none
//		Out: All comment data
//-----------------------------------------------------------------------------
function GetAllComments($ip = "")
{
	if($ip != "") return GetDatabase()->RunQuery("SELECT * FROM blog_comments WHERE client_ip='$ip' ORDER BY comment_timestamp DESC");
	return GetDatabase()->RunQuery("SELECT * FROM blog_comments ORDER BY comment_timestamp DESC");
}

//-----------------------------------------------------------------------------
// Securely hash a password (not reversible)
//		In: Plain text password
//		Out: Hashed password
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
//		In: Current password, New password and New password again (confirm)
//		Out: none
//-----------------------------------------------------------------------------
function ChangePassword($currentpassword, $newpassword, $confirmedpassword)
{
	if($newpassword != $confirmedpassword)
		return false; //Passwords dont match
	
	$db = GetDatabase();
	$row = $db->GetRow($db->RunQuery("SELECT username FROM site_users WHERE user_id='1'"));
	
	if(!CheckCredentials($row[0], $currentpassword))
		return false; //Current password is wrong
	
	$hash = HashPassword($newpassword);
	
	$db->RunQuery("UPDATE site_users SET password='$hash' WHERE user_id='1'");
	return true;
}
?>