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

foreach(glob("controllers/*.controller.php") as $file)
	require_once($file);


//default to the login page unless already logged in
IsLoggedIn() ? $page = "index" : $page = "login";

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
				if(CheckCredentials($u, $p)) { $_SESSION['user'] = $u; $page = "index"; } else { $page = "login"; }
			}
			break;
		case "logout":
			KillSession(); $page = "login";	break;
		case "main":
			IsLoggedIn() ? $page = "index" : $page = "login"; break;
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

$output = OpenTemplate("page.tpl");
$pagetemplate = OpenTemplate("$page.tpl");
$widgettemplate = OpenTemplate("sidewidget.tpl");

new AdminBasePageController($output, "test");

switch($page)
{
case "index": new AdminBasePageController($pagetemplate, "index"); break;
case "listcomments": new ListCommentsPageController($pagetemplate); break;
case "listposts": new ListPostsPageController($pagetemplate); break;
case "listpages": new ListPagesPageController($pagetemplate); break;
case "serverinfo": new AdminServerInfoController($pagetemplate); break;
case "password": new AdminBasePageController($pagetemplate, "password"); break;
case "ipfilter": new AdminIPFilterPageController($pagetemplate); break;
case "edit": new AdminEditPageController($pagetemplate); break;
}

new AdminSideWidgetController($widgettemplate);

ReplaceTag("{PAGE}", $pagetemplate, $output);
ReplaceTag("{WIDGET}", $widgettemplate, $output);
print $output;
?>
