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
		$pagetemplate = (defined('ADMINPAGE') ? OpenTemplate("../../" . TEMPLATE_FOLDER . "/page.tpl") : OpenTemplate("page.tpl"));
		ReplaceTag("{PAGE}", OpenTemplate("$template.tpl"), $pagetemplate);
		ReplaceTag("{WIDGET}", OpenTemplate("$widget.tpl"), $pagetemplate);
		
		if(defined('ADMINPAGE'))
		{
			new AdminBasePageController($pagetemplate);
			switch($template)
			{
				case "listcomments": new ListCommentsPageController($pagetemplate); break;
				case "listposts": new ListPostsPageController($pagetemplate); break;
				case "listpages": new ListPagesPageController($pagetemplate); break;
				case "serverinfo": new AdminServerInfoController($pagetemplate); break;
				case "ipfilter": new AdminIPFilterPageController($pagetemplate); break;
				case "edit": new AdminEditPageController($pagetemplate); break;
			}
			if($widget = "userwidget") new AdminUserWidgetController($pagetemplate);
		}
		else
		{
			switch($template)
			{
				case "generic": 	$e = explode(' ', $title);  //Get page name from last word of title
									new GenericPageController($pagetemplate, strtolower(array_pop($e))); 
									break;
									
				case "blog": 		new BlogPageController($pagetemplate); break;
			}
			if($widget == "postswidget") new PostsWidgetController($pagetemplate);
		}
		
		new BasePageController($pagetemplate, $title);
		echo $pagetemplate;
	}
}
?>