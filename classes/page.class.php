<?php
//-----------------------------------------------------------------------------
// Page class
//
//  Builds pages using a template.
//-----------------------------------------------------------------------------
foreach(glob("controllers/*.controller.php") as $file)
	require_once($file);
	
class Page
{
	//-----------------------------------------------------------------------------
	// Constructor
	//-----------------------------------------------------------------------------
	public function __construct($title, $widget, $template)
	{
		$pagetemplate = OpenTemplate("page.tpl");
		$contenttemplate = OpenTemplate("$template.tpl");
		$widgettemplate = OpenTemplate("$widget.tpl");
		
		new BasePageController($pagetemplate, $title);
		
		if(defined('ADMINPAGE'))
		{
			new AdminBasePageController($pagetemplate);
			switch($template)
			{
				case "index": new AdminBasePageController($contenttemplate); break;
				case "listcomments": new ListCommentsPageController($contenttemplate); break;
				case "listposts": new ListPostsPageController($contenttemplate); break;
				case "listpages": new ListPagesPageController($contenttemplate); break;
				case "serverinfo": new AdminServerInfoController($contenttemplate); break;
				case "password": new AdminBasePageController($contenttemplate); break;
				case "ipfilter": new AdminIPFilterPageController($contenttemplate); break;
				case "edit": new AdminEditPageController($contenttemplate); break;
			}
			new AdminSideWidgetController($widgettemplate);
		}
		else
		{
			switch($template)
			{
				case "generic": 	$e = explode(' ', $title);  //Get page name from last word of title
									new GenericPageController($contenttemplate, strtolower(array_pop($e))); 
									break;
									
				case "blog": 		new BlogPageController($contenttemplate); break;
			}
			if($widget == "postswidget") new PostsWidgetController($widgettemplate);
		}
		ReplaceTag("{PAGE}", $contenttemplate, $pagetemplate);
		ReplaceTag("{WIDGET}", $widgettemplate, $pagetemplate);
		echo $pagetemplate;
	}
}
?>