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
	case "about": new Page(SITE_TITLE . " :: About", "about", "twitterwidget", "generic", 'generic'); break;
	case "blog": new Page(SITE_TITLE . " :: Blog", "blog", "postswidget", "blog", 'blog'); break;
	case "contact": new Page(SITE_TITLE . " :: Contact", "contact", "twitterwidget", "generic", 'generic'); break;
	case "photos": new Page(SITE_TITLE . " :: Photos", "photos", "twitterwidget", "generic", 'generic'); break;
	case "videos": new Page(SITE_TITLE . " :: Videos", "videos", "twitterwidget", "generic", 'generic'); break;
	case "projects": new Page(SITE_TITLE . " :: Projects", "projects", "twitterwidget", "generic", 'generic'); break;
	case "404": new Page(SITE_TITLE, "error404", "twitterwidget", "generic", 'generic'); break;
	default: new Page(); break;
	}
}
else { new Page(); }
?>
