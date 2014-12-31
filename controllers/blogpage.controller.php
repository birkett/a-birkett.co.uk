<?php
//-----------------------------------------------------------------------------
// Build the blog pages
//		In: Unparsed template
//		Out: Parsed template
//
//  !!! This is a custom controller, only used for the Blog pages !!!
//-----------------------------------------------------------------------------
class BlogPageController
{
	public function __construct(&$output)
	{
		$db = GetDatabase();
		//Clamp pagniation offset
		(isset($_GET['offset']) && is_numeric($_GET['offset']) && $_GET['offset'] >= 1 && $_GET['offset'] < 100000) ? $offset = $_GET['offset'] - 1 : $offset = 0;

		//Single post mode
		if(isset($_GET['postid']) && is_numeric($_GET['postid']) && $_GET['postid'] >= 0 && $_GET['postid'] < 500000) 
		{ 
			$result = GetPosts("single", $_GET['postid'], false); 
			if($db->GetNumRows($result) == 0) { header('Location: /404'); return; } //Back out if we didnt find any posts
					
			//Show comments
			$comments = GetCommentsOnPost($_GET['postid']);
			if($db->GetNumRows($comments) != 0)
			{
				while(list($cid, $pid, $cusername, $ctext, $ctimestamp, $cip) = $db->GetRow($comments))
				{
					$tags = [
						"{COMMENTAUTHOR}" => stripslashes($cusername),
						"{COMMENTTIMESTAMP}" => date(DATE_FORMAT, $ctimestamp),
						"{COMMENTCONTENT}" => stripslashes($ctext)
					];
					$temp = LogicTag("{COMMENT}", "{/COMMENT}", $output);
					ParseTags($tags, $temp);
					$temp .= "{COMMENT}";
					ReplaceTag("{COMMENT}", $temp, $output); //Add this comment to the output
				}
			}
			
			//Snow new comments box
			$tags = [ "{COMMENTPOSTID}" => $_GET['postid'], "{RECAPTCHAKEY}" => RECAPTCHA_PUBLIC_KEY ];
			ParseTags($tags, $output); 
			
			RemoveLogicTag("{PAGINATION}", "{/PAGINATION}", $output); //No pagination in single post mode
		}
		//Normal mode
		else 
		{ 
			$result = GetPosts("page", $offset, false); 
			if($db->GetNumRows($result) == 0) { header('Location: /404'); return; } //Back out if we didnt find any posts
		
			//Show Pagination
			$numberofposts = GetNumberOfPosts();
			if($numberofposts > BLOG_POSTS_PER_PAGE)
			{
				if($offset > 0) 
				{
					$tags = [ "{PAGEPREVIOUSLINK}" => "/blog/page/$offset",	"{PAGEPREVIOUSTEXT}" => "Previous Page" ];
					ParseTags($tags, $output);
				}
				if(($offset+1) * BLOG_POSTS_PER_PAGE < $numberofposts) 
				{
					$linkoffset = $offset + 2;
					$tags = [ "{PAGENEXTLINK}" => "/blog/page/$linkoffset", "{PAGENEXTTEXT}" => "Next Page" ];
					ParseTags($tags, $output);
				}
			}
			else RemoveLogicTag("{PAGINATION}", "{/PAGINATION}", $output); //Hide pagniation when too few posts
			
			RemoveLogicTag("{NEWCOMMENT}", "{/NEWCOMMENT}", $output); //No comments box in normal mode
		}
		
		//Rendering code
		while(list($id, $timestamp, $title, $content, $draft) = $db->GetRow($result))
		{
			$tags = [
				"{POSTTIMESTAMP}" => date(DATE_FORMAT, $timestamp),
				"{POSTID}" => $id,
				"{POSTTITLE}" => $title,
				"{POSTCONTENT}" => $content,
				"{COMMENTCOUNT}" => GetNumberOfComments($id)
			];
			$temp = LogicTag("{BLOGPOST}", "{/BLOGPOST}", $output);
			ParseTags($tags, $temp);
			$temp .= "\n{BLOGPOST}";
			ReplaceTag("{BLOGPOST}", $temp, $output); //Add this post to the output
		}
		
		RemoveLogicTag("{BLOGPOST}", "{/BLOGPOST}", $output);
		RemoveLogicTag("{COMMENT}", "{/COMMENT}", $output);
	
		//Clean up the tags if not already replaced
		$cleantags = [ "{PAGEPREVIOUSLINK}", "{PAGEPREVIOUSTEXT}", "{PAGENEXTLINK}", "{PAGENEXTTEXT}", 
						"{PAGINATION}", "{/PAGINATION}", "{NEWCOMMENT}", "{/NEWCOMMENT}" ];
		RemoveTags($cleantags, $output);
	}
}
?>