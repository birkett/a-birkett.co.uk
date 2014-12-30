<?php
//-----------------------------------------------------------------------------
// Page router
//
//-----------------------------------------------------------------------------
require_once("config.php");
require_once("classes/database.class.php");
require_once("classes/page.class.php");
require_once("functions.php");

if(isset($_GET['page'])) 
{ 
	switch($_GET['page'])
	{
	//URL						//Page title					//Widget			//Template
	case "about": 		new Page(SITE_TITLE . " :: About", 		"twitterwidget", 	"generic"); break;
	case "blog": 		new Page(SITE_TITLE . " :: Blog", 		"postswidget", 		"blog"	 ); break;
	case "contact": 	new Page(SITE_TITLE . " :: Contact", 	"twitterwidget", 	"generic"); break;
	case "photos": 		new Page(SITE_TITLE . " :: Photos", 	"twitterwidget", 	"generic"); break;
	case "videos": 		new Page(SITE_TITLE . " :: Videos", 	"twitterwidget", 	"generic"); break;
	case "projects": 	new Page(SITE_TITLE . " :: Projects", 	"twitterwidget", 	"generic"); break;
	case "404": 		new Page(SITE_TITLE . " :: Error",		"twitterwidget", 	"generic"); break;
	default: 			new Page(SITE_TITLE . " :: Home",		"twitterwidget", 	"index"  ); break;
	}
}
//Default when nothing requested
else { new Page(SITE_TITLE . " :: Home", "twitterwidget", "index" ); }
?>
