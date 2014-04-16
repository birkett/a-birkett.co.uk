<?php
//-----------------------------------------------------------------------------
// Page class
//
//  Builds pages using a template.
//-----------------------------------------------------------------------------

class Page
{
	//-----------------------------------------------------------------------------
	// Constructor
	//		In: Database name
	//		Out: none
	//-----------------------------------------------------------------------------
	public function __construct($title = SITE_TITLE, $pagename = "index", $widget = "twitterwidget", $template = "index", $controller = '')
	{
		require_once("template/header.tpl");
		require_once("template/$template.tpl");
		require_once("template/$widget.tpl");
		require_once("template/footer.tpl");
	}

	//-----------------------------------------------------------------------------
	// Destructor
	//		In: none
	//		Out: none
	//-----------------------------------------------------------------------------
	public function __destruct()
	{
	}
}
?>