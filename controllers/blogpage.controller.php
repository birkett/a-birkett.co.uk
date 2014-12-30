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
		$posttemplate = LogicTag("{BLOGPOST}", "{/BLOGPOST}", $output);
		while(list($id, $timestamp, $title, $content, $draft) = GetDatabase()->GetRow($result))
		{
			$tags = [
				"{POSTTIMESTAMP}" => date(DATE_FORMAT, $timestamp),
				"{POSTID}" => $id,
				"{POSTTITLE}" => $title,
				"{POSTCONTENT}" => $content,
				"{COMMENTCOUNT}" => GetNumberOfComments($id)
			];
			$temp = $posttemplate;
			ParseTags($tags, $temp);
			$temp .= "\n{BLOGPOSTS}";
			ReplaceTag("{BLOGPOSTS}", $temp, $output); //Add this post to the output
		}
		RemoveLogicTag("{BLOGPOST}", "{/BLOGPOST}", $output);

		//Show comments if in single mode
		if(isset($singlemode))
		{
			$comments = GetCommentsOnPost($_GET['postid']);
			if(GetDatabase()->GetNumRows($comments) != 0)
			{
				$commenttemplate = LogicTag("{COMMENT}", "{/COMMENT}", $output);
				while(list($cid, $pid, $cusername, $ctext, $ctimestamp, $cip) = GetDatabase()->GetRow($comments))
				{
					$tags = [
						"{COMMENTAUTHOR}" => stripslashes($cusername),
						"{COMMENTTIMESTAMP}" => date(DATE_FORMAT, $ctimestamp),
						"{COMMENTCONTENT}" => stripslashes($ctext)
					];
					$temp = $commenttemplate;
					ParseTags($tags, $temp);
					$temp .= "{COMMENTS}";
					ReplaceTag("{COMMENTS}", $temp, $output); //Add this comment to the output
				}
			}
		}
		RemoveLogicTag("{COMMENT}", "{/COMMENT}", $output);
		
		//Paginate when appropriate
		if(!isset($singlemode) && GetNumberOfPosts() > BLOG_POSTS_PER_PAGE)
		{
			if($offset > 0) 
			{
				$linkoffset = $offset - 1;
				$tags = [
					"{PAGEPREVIOUSLINK}" => "/blog/page/$linkoffset",
					"{PAGEPREVIOUSTEXT}" => "Previous Page",
				];
				ParseTags($tags, $output);
			}
			
			if(($offset+1) * BLOG_POSTS_PER_PAGE < GetNumberOfPosts()) 
			{
				$linkoffset = $offset + 1;
				$tags = [
					"{PAGENEXTLINK}" => "/blog/page/$linkoffset",
					"{PAGENEXTTEXT}" => "Next Page",
				];
				ParseTags($tags, $output);
			}
		}
		else
		{
			RemoveLogicTag("{PAGINATION}", "{/PAGINATION}", $output);
		}

		//Show new comment box when appropriate
		if(isset($singlemode))
		{
			$tags = [ 
				"{COMMENTPOSTID}" => $_GET['postid'],
				"{RECAPTCHAKEY}" => RECAPTCHA_PUBLIC_KEY
			];
			ParseTags($tags, $output);
		}
		else
		{
			RemoveLogicTag("{NEWCOMMENT}", "{/NEWCOMMENT}", $output);
		}
		
		//Clean up the tags if not already replaced
		$cleantags = [ "{PAGEPREVIOUSLINK}", "{PAGEPREVIOUSTEXT}", "{PAGENEXTLINK}", "{PAGENEXTTEXT}", 
						"{BLOGPOSTS}", "{COMMENTS}", "{PAGINATION}", "{/PAGINATION}", "{NEWCOMMENT}", "{/NEWCOMMENT}" ];
		RemoveTags($cleantags, $output);
	}
}
?>