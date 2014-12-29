<?php
//-----------------------------------------------------------------------------
// Page class
//
//  Builds pages using a template.
//-----------------------------------------------------------------------------
foreach (glob("controllers/*controller.php") as $file)
{
	require_once($file);
}
	
class Page
{
	//-----------------------------------------------------------------------------
	// Constructor
	//-----------------------------------------------------------------------------
	public function __construct($title = SITE_TITLE, $pagename = "index", $widget = "twitterwidget", $template = 'index')
	{
		$output = OpenTemplate("page.tpl");
		$pagetemplate = OpenTemplate("$template.tpl");
		$widgettemplate = OpenTemplate("$widget.tpl");

		new BasePageController($output, $title);
		
		switch($template)
		{
			case "generic": new GenericPageController($pagetemplate, $pagename); break;
			case "blog": new BlogPageController($pagetemplate); break;
		}
		
		if($widget == "postswidget")
			new PostsWidgetController($widgettemplate);
			
		ReplaceTag("{PAGE}", $pagetemplate, $output);
		ReplaceTag("{WIDGET}", $widgettemplate, $output);
		print $output;
	}

	//-----------------------------------------------------------------------------
	// Destructor
	//-----------------------------------------------------------------------------
	public function __destruct()
	{
	}
}
?>