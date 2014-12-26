<?php
//-----------------------------------------------------------------------------
// Admin index.
//
//  Page proxy for admin pages
//-----------------------------------------------------------------------------
session_start();

require_once("../config.php");
require_once("../classes/database.class.php");
require_once("../functions.php");
require_once("adminfunctions.php");

//default to the login page unless already logged in
IsLoggedIn() ? $page = "admin" : $page = "login";

//Decide what to show based on ?action=x
if(isset($_GET['action']))
{
	switch($_GET['action'])
	{
		case "login":
			if(isset($_POST['username']) && isset($_POST['password']))
			{
				$u = Sanitize($_POST['username']);
				$p = Sanitize($_POST['password']);
				if(CheckCredentials($u, $p)) { $_SESSION['user'] = $u; $page = "admin"; } else { $page = "login"; }
			}
			break;
		case "logout":
			KillSession(); $page = "login";	break;
		case "main":
			IsLoggedIn() ? $page = "admin" : $page = "login"; break;
		case "edit":
			IsLoggedIn() ? $page = "edit" : $page = "login"; break;
		case "listposts":
			IsLoggedIn() ? $page = "listposts" : $page = "login"; break;
		case "listcomments":
			IsLoggedIn() ? $page = "listcomments" : $page = "login"; break;
		case "listpages":
			IsLoggedIn() ? $page = "listpages" : $page = "login"; break;
		case "ipfilter":
			IsLoggedIn() ? $page = "ipfilter" : $page = "login"; break;
		case "serverinfo":
			IsLoggedIn() ? $page = "serverinfo" : $page = "login"; break;
		case "password":
			IsLoggedIn() ? $page = "password" : $page = "login"; break;
	}
}

require_once("template/header.tpl");
require_once("template/$page.tpl");
require_once("template/footer.tpl");
?>
