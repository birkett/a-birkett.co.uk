<?php
//-----------------------------------------------------------------------------
// Admin index.
//
//  Page proxy for admin pages
//-----------------------------------------------------------------------------
define('ADMINPAGE', 1); //Set so the page class will include admin controllers

session_start();

require_once("../config.php");
require_once("../classes/database.class.php");
require_once("../classes/page.class.php");
require_once("../functions.php");
require_once("adminfunctions.php");

if(IsLoggedIn())
{
	if(isset($_GET['action'])) 
	{ 
		switch($_GET['action'])
		{
		//URL						//Page title					//Widget		//Template
		case "password": 		new Page("Admin :: Password", 		"userwidget", 	"password"		); break;
		case "serverinfo": 		new Page("Admin :: Server Info", 	"userwidget", 	"serverinfo"	); break;
		case "ipfilter": 		new Page("Admin :: IP Filter", 		"userwidget", 	"ipfilter"		); break;
		case "listpages": 		new Page("Admin :: List Pages", 	"userwidget", 	"listpages"		); break;
		case "listcomments": 	new Page("Admin :: List Comments", 	"userwidget", 	"listcomments"	); break;
		case "listposts": 		new Page("Admin :: List Posts", 	"userwidget", 	"listposts"		); break;
		case "edit": 			new Page("Admin :: Editor",			"userwidget", 	"edit"			); break;
		case "logout":			KillSession();
								new Page("Admin :: Login",			"userwidget", 	"login"			); break;
		default: 				new Page("Admin :: Main",			"userwidget", 	"index"  		); break;
		}
	}
	//Default when nothing requested
	else { new Page("Admin :: Main", "userwidget", "index" ); }
}
else
{
	if(isset($_POST['username']) && isset($_POST['password']))
	{
		$u = Sanitize($_POST['username']);
		$p = Sanitize($_POST['password']);
		if(CheckCredentials($u, $p)) 
		{ 
			$_SESSION['user'] = $u; 
			new Page("Admin :: Main", "userwidget", "index");
			return;
		}
	}
	new Page("Admin :: Login", "userwidget", "login");
}
?>
