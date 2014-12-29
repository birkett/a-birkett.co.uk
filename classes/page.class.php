<?php
//-----------------------------------------------------------------------------
// Page class
//
//  Builds pages using a template.
//-----------------------------------------------------------------------------

function PostsWidgetcontroller(&$output)
{
	$posts = GetPosts("all", 0, false);
	$last_month = NULL;
	$postlist = "";
	while($row = GetDatabase()->GetRow($posts))
	{
		list($id, $timestamp, $title, $draft) = $row;
		$month = date("F Y", $timestamp);
		if($month != $last_month)
		{
			if($last_month != NULL)
			{
				$postlist .= '</ul></li>';
			}
			$last_month = $month;
			$postlist .= '<li><span>' . $month . '</span><ul>';
		}
		$postlist .= '<li><span><a href="/blog/' . $id . '">' . $title . '</a></span></li>';
	}
	$postlist .= '</ul></li>';
	
	$output = str_replace("{POSTLIST}", $postlist, $output);
}

function BlogPageController(&$output)
{
	//Pagniation
	$offset = 0; //default
	if(isset($_GET['offset']) && is_numeric($_GET['offset']) && $_GET['offset'] >= 0 && $_GET['offset'] < 100000) { $offset = $_GET['offset']; } 

	//Single post mode
	if(isset($_GET['postid']) && is_numeric($_GET['postid']) && $_GET['postid'] >= 0 && $_GET['postid'] < 500000) 
	{ 
		$postid = $_GET['postid'];
		$result = GetPosts("single", $postid, false); 
		if(GetDatabase()->GetNumRows($result) == 0)
		{
			header('Location: /404');				
			return;
		}
		$singlemode = true;
	}
	//Normal mode
	else { $result = GetPosts("page", $offset, false); }
					
	//Rendering code
	while($row = GetDatabase()->GetRow($result))
	{
		list($id, $timestamp, $title, $content, $draft) = $row;
		
		$posttemplate = file_get_contents("template/blogpost.tpl");
		$posttemplate = str_replace("{POSTTIMESTAMP}", date(DATE_FORMAT, $timestamp), $posttemplate);
		$posttemplate = str_replace("{POSTID}", $id, $posttemplate);
		$posttemplate = str_replace("{POSTTITLE}", $title, $posttemplate);
		$posttemplate = str_replace("{POSTCONTENT}", $content, $posttemplate);
		$posttemplate = str_replace("{COMMENTCOUNT}", GetNumberOfComments($id), $posttemplate);
		
		$output = str_replace("{BLOGPOST}", $posttemplate, $output); //Add this post to the output
	}

	//Show comments box if in single mode
	if(isset($singlemode))
	{
		$comments = GetCommentsOnPost($postid);
		$numberofcomments = GetDatabase()->GetNumRows($comments);
		if($numberofcomments != 0)
		{
			while($comment = GetDatabase()->GetRow($comments))
			{
				$commenttemplate = file_get_contents("template/blogcomments.tpl");
				$commenttemplate = str_replace("{COMMENTAUTHOR}", stripslashes($comment[2]), $commenttemplate);
				$commenttemplate = str_replace("{COMMENTTIMESTAMP}", date("l dS F Y", $comment[4]), $commenttemplate);
				$commenttemplate = str_replace("{COMMENTCONTENT}", stripslashes($comment[3]), $commenttemplate);

				$output = str_replace("{COMMENT}", $commenttemplate, $output); //Add this comment to the output
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
			$paginationtemplate = str_replace("{PAGEPREVIOUSLINK}", "/blog/page/$linkoffset", $paginationtemplate);
			$paginationtemplate = str_replace("{PAGEPREVIOUSTEXT}", "Previous Page", $paginationtemplate);
		}
		
		if(($offset+1) * BLOG_POSTS_PER_PAGE < GetNumberOfPosts()) 
		{
			$linkoffset = $offset + 1;
			$paginationtemplate = str_replace("{PAGENEXTLINK}", "/blog/page/$linkoffset", $paginationtemplate);
			$paginationtemplate = str_replace("{PAGENEXTTEXT}", "Next Page", $paginationtemplate);
		}
		
		//Clean up the tags if not already replaced
		$paginationtemplate = str_replace("{PAGEPREVIOUSLINK}", "", $paginationtemplate);
		$paginationtemplate = str_replace("{PAGEPREVIOUSTEXT}", "", $paginationtemplate);
		$paginationtemplate = str_replace("{PAGENEXTLINK}", "", $paginationtemplate);
		$paginationtemplate = str_replace("{PAGENEXTTEXT}", "", $paginationtemplate);

		$output = str_replace("{PAGINATION}", $paginationtemplate, $output); //Add this pagination to the output
	}

	//Show new comment box when appropriate
	if(isset($singlemode))
	{
		$newcommenttemplate = file_get_contents("template/blognewcomment.tpl");
		$newcommenttemplate = str_replace("{POSTID}", $id, $newcommenttemplate);
		$newcommenttemplate = str_replace("{RECAPTCHAKEY}", RECAPTCHA_PUBLIC_KEY, $newcommenttemplate);
		
		$output = str_replace("{NEWCOMMENTBOX}", $newcommenttemplate, $output); //Add the new comment box to the output
	}
	
	$output = str_replace("{BLOGPOST}", "", $output); //Remove the last BLOGPOST marker in the output
	$output = str_replace("{PAGINATION}", "", $output); //Clean up any unused PAGINATION tag
	$output = str_replace("{COMMENT}", "", $output); //Remove the last COMMENT marker in the output
	$output = str_replace("{NEWCOMMENTBOX}", "", $output); //Clean up any unused COMMENTBOX tags
}

function StaticPageController(&$output)
{
}

function GenericPageController(&$output, $name)
{
	$page = GetPage($name);
	$output = str_replace("{PAGETITLE}", $page[0], $output);
	$output = str_replace("{PAGECONTENT}", $page[1], $output);
}

function BasePageController(&$output, $title)
{
	$output = str_replace("{BASEURL}", BASE_URL, $output);
	$output = str_replace("{TITLE}", $title, $output);
	$output = str_replace("{RAND2551}", rand(0, 255), $output);
	$output = str_replace("{RAND2552}", rand(0, 255), $output);
	$output = str_replace("{RAND2553}", rand(0, 255), $output);
	$output = str_replace("{RAND12}", rand(1, 2), $output);
	$output = str_replace("{THISYEAR}", date('Y'), $output);
	$output = str_replace("{EXTRASTYLESHEET}", (CHRISTMAS ? '<link rel="stylesheet" href="css/christmas.css" />\n' : ""), $output);
}

class Page
{
	//-----------------------------------------------------------------------------
	// Constructor
	//		In: Database name
	//		Out: none
	//-----------------------------------------------------------------------------
	public function __construct($title = SITE_TITLE, $pagename = "index", $widget = "twitterwidget", $template = "index", $controller = 'static')
	{
		$output  = file_get_contents("template/header.tpl");
		$output .= file_get_contents("template/$template.tpl");
		$output .= file_get_contents("template/$widget.tpl");
		$output .= file_get_contents("template/footer.tpl");
		
		BasePageController($output, $title);

		if($controller == "generic")
			GenericPageController($output, $pagename);
		
		if($controller == "blog")
			BlogPageController($output);
			
		if($controller == "static")
			StaticPageController($output);
			
		if($widget == "postswidget")
			PostsWidgetController($output);
			
		print $output;
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