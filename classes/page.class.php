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
	//-----------------------------------------------------------------------------
	public function __construct($title = SITE_TITLE, $pagename = "index", $widget = "twitterwidget", $template = 'index')
	{
		$output = file_get_contents("template/page.tpl");
		$pagetemplate = file_get_contents("template/$template.tpl");
		$widgettemplate = file_get_contents("template/$widget.tpl");

		$this->BasePageController($output, $title);
		
		switch($template)
		{
			case "generic": $this->GenericPageController($pagetemplate, $pagename); break;
			case "blog": $this->BlogPageController($pagetemplate); break;
		}
		
		if($widget == "postswidget")
			$this->PostsWidgetController($widgettemplate);
			
		$this->ReplaceTag("{PAGE}", $pagetemplate, $output);
		$this->ReplaceTag("{WIDGET}", $widgettemplate, $output);
		print $output;
	}

	//-----------------------------------------------------------------------------
	// Destructor
	//-----------------------------------------------------------------------------
	public function __destruct()
	{
	}
	
	//-----------------------------------------------------------------------------
	// Replace a tag with a string (for inserting sub templates into the output)
	//		In: Tag and parsed sub template
	//		Out: Parsed template
	//-----------------------------------------------------------------------------
	private function ReplaceTag($tag, $string, &$output)
	{
		$output = str_replace($tag, $string, $output);
	}
	
	//-----------------------------------------------------------------------------
	// Parse the tags in a given array to the template
	//		In: Tags and Unparsed template
	//		Out: Parsed template
	//-----------------------------------------------------------------------------
	private function ParseTags(&$tags, &$output)
	{
		foreach ($tags as $key => $val)
			$this->ReplaceTag($key, $val, $output);
	}
	
	//-----------------------------------------------------------------------------
	// Remove any left over tags from the parsed template
	//		In: Tags and Parsed template
	//		Out: Clean Parsed template
	//-----------------------------------------------------------------------------
	private function RemoveTags(&$tags, &$output)
	{
		foreach ($tags as $tag)
			$this->ReplaceTag($tag, "", $output);
	}
	
	//-----------------------------------------------------------------------------
	// Parse essential tags in the basic page template
	//		In: Unparsed template
	//		Out: Parsed template
	//-----------------------------------------------------------------------------
	private function BasePageController(&$output, $title)
	{
		$tags = [
			"{BASEURL}" => BASE_URL,
			"{TITLE}" => $title,
			"{RAND2551}" => rand(0, 255),
			"{RAND2552}" => rand(0, 255),
			"{RAND2553}" => rand(0, 255),	
			"{RAND12}" => rand(1, 2),
			"{THISYEAR}" => date('Y'),
			"{EXTRASTYLESHEET}" => (CHRISTMAS ? '<link rel="stylesheet" href="css/christmas.css" />' : "")
		];
		$this->ParseTags($tags, $output);
	}
	
	//-----------------------------------------------------------------------------
	// Build a generic page stored in the database
	//		In: Unparsed template
	//		Out: Parsed template
	//-----------------------------------------------------------------------------
	private function GenericPageController(&$output, $name)
	{
		$page = GetPage($name);
		$tags = [
			"{PAGETITLE}" => $page[0],
			"{PAGECONTENT}" => $page[1]
		];
		$this->ParseTags($tags, $output);
	}

	//-----------------------------------------------------------------------------
	// Build the blog pages
	//		In: Unparsed template
	//		Out: Parsed template
	//-----------------------------------------------------------------------------
	private function BlogPageController(&$output)
	{
		//Pagniation
		$offset = 0; //default
		if(isset($_GET['offset']) && is_numeric($_GET['offset']) && $_GET['offset'] >= 0 && $_GET['offset'] < 100000) { $offset = $_GET['offset']; } 

		//Single post mode
		if(isset($_GET['postid']) && is_numeric($_GET['postid']) && $_GET['postid'] >= 0 && $_GET['postid'] < 500000) 
		{ $result = GetPosts("single", $_GET['postid'], false); $singlemode = true;	}
		//Normal mode
		else { $result = GetPosts("page", $offset, false); }
		
		//Back out if we didnt find any posts
		if(GetDatabase()->GetNumRows($result) == 0) { header('Location: /404'); return; }
						
		//Rendering code
		while(list($id, $timestamp, $title, $content, $draft) = GetDatabase()->GetRow($result))
		{
			$tags = [
				"{POSTTIMESTAMP}" => date(DATE_FORMAT, $timestamp),
				"{POSTID}" => $id,
				"{POSTTITLE}" => $title,
				"{POSTCONTENT}" => $content,
				"{COMMENTCOUNT}" => GetNumberOfComments($id)
			];
			$posttemplate = file_get_contents("template/blogpost.tpl");
			$this->ParseTags($tags, $posttemplate);
			$this->ReplaceTag("{BLOGPOST}", $posttemplate, $output); //Add this post to the output
		}

		//Show comments box if in single mode
		if(isset($singlemode))
		{
			$comments = GetCommentsOnPost($_GET['postid']);
			if(GetDatabase()->GetNumRows($comments) != 0)
			{
				while(list($cid, $pid, $cusername, $ctext, $ctimestamp, $cip) = GetDatabase()->GetRow($comments))
				{
					$tags = [
						"{COMMENTAUTHOR}" => stripslashes($cusername),
						"{COMMENTTIMESTAMP}" => date("l dS F Y", $ctimestamp),
						"{COMMENTCONTENT}" => stripslashes($ctext)
					];
					$commenttemplate = file_get_contents("template/blogcomments.tpl");
					$this->ParseTags($tags, $commenttemplate);
					$this->ReplaceTag("{COMMENT}", $commenttemplate, $output); //Add this comment to the output
				}
			}
		}
		
		//Paginate when appropriate
		else if(GetNumberOfPosts() > BLOG_POSTS_PER_PAGE)
		{
			$paginationtemplate = file_get_contents("template/blogpagination.tpl");
			if($offset > 0) 
			{
				$linkoffset = $offset - 1;
				$tags = [
					"{PAGEPREVIOUSLINK}" => "/blog/page/$linkoffset",
					"{PAGEPREVTEXT}" => "Previous Page",
				];
				$this->ParseTags($tags, $paginationtemplate);
			}
			
			if(($offset+1) * BLOG_POSTS_PER_PAGE < GetNumberOfPosts()) 
			{
				$linkoffset = $offset + 1;
				$tags = [
					"{PAGENEXTIOUSLINK}" => "/blog/page/$linkoffset",
					"{PAGENEXTTEXT}" => "Next Page",
				];
				$this->ParseTags($tags, $paginationtemplate);
			}
			$this->ReplaceTag("{PAGINATION}", $paginationtemplate, $output); //Add this pagination to the output
		}

		//Show new comment box when appropriate
		if(isset($singlemode))
		{
			$tags = [ 
				"{POSTID}" => $id,
				"{RECAPTCHAKEY}" => RECAPTCHA_PUBLIC_KEY
			];
			$newcommenttemplate = file_get_contents("template/blognewcomment.tpl");
			$this->ParseTags($tags, $newcommenttemplate);
			$this->ReplaceTag("{NEWCOMMENTBOX}", $newcommenttemplate, $output); //Add the new comment box to the output
		}
		
		//Clean up the tags if not already replaced
		$cleantags = [ "{PAGEPREVIOUSLINK}", "{PAGEPREVIOUSTEXT}", "{PAGENEXTLINK}", "{PAGENEXTTEXT}", "{BLOGPOST}", "{PAGINATION}", "{COMMENT}", "{NEWCOMMENTBOX}" ];
		$this->RemoveTags($cleantags, $output);
	}
	
	//-----------------------------------------------------------------------------
	// Build the post list widget
	//		In: Unparsed template
	//		Out: Parsed template
	//  TODO: This is the only non pure PHP function. Move the HTML out?
	//-----------------------------------------------------------------------------
	private function PostsWidgetController(&$output)
	{
		$posts = GetPosts("all");
		$last_month = NULL;
		$postlist = "";
		while(list($id, $timestamp, $title, $draft) = GetDatabase()->GetRow($posts))
		{
			$month = date("F Y", $timestamp);
			if($month != $last_month)
			{
				if($last_month != NULL)
					$postlist .= '</ul></li>';
				$last_month = $month;
				$postlist .= '<li><span>' . $month . '</span><ul>';
			}
			$postlist .= '<li><span><a href="/blog/' . $id . '">' . $title . '</a></span></li>';
		}
		$postlist .= '</ul></li>';
		$this->ReplaceTag("{POSTLIST}", $postlist, $output);
	}
}
?>