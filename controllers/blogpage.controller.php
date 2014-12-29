<?php
//-----------------------------------------------------------------------------
// Build the blog pages
//		In: Unparsed template
//		Out: Parsed template
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
		while(list($id, $timestamp, $title, $content, $draft) = GetDatabase()->GetRow($result))
		{
			$tags = [
				"{POSTTIMESTAMP}" => date(DATE_FORMAT, $timestamp),
				"{POSTID}" => $id,
				"{POSTTITLE}" => $title,
				"{POSTCONTENT}" => $content,
				"{COMMENTCOUNT}" => GetNumberOfComments($id)
			];
			$posttemplate = OpenTemplate("blogpost.tpl");
			ParseTags($tags, $posttemplate);
			ReplaceTag("{BLOGPOST}", $posttemplate, $output); //Add this post to the output
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
					$commenttemplate = OpenTemplate("blogcomments.tpl");
					ParseTags($tags, $commenttemplate);
					ReplaceTag("{COMMENT}", $commenttemplate, $output); //Add this comment to the output
				}
			}
		}
		
		//Paginate when appropriate
		else if(GetNumberOfPosts() > BLOG_POSTS_PER_PAGE)
		{
			$paginationtemplate = OpenTemplate("blogpagination.tpl");
			if($offset > 0) 
			{
				$linkoffset = $offset - 1;
				$tags = [
					"{PAGEPREVIOUSLINK}" => "/blog/page/$linkoffset",
					"{PAGEPREVIOUSTEXT}" => "Previous Page",
				];
				ParseTags($tags, $paginationtemplate);
			}
			
			if(($offset+1) * BLOG_POSTS_PER_PAGE < GetNumberOfPosts()) 
			{
				$linkoffset = $offset + 1;
				$tags = [
					"{PAGENEXTLINK}" => "/blog/page/$linkoffset",
					"{PAGENEXTTEXT}" => "Next Page",
				];
				ParseTags($tags, $paginationtemplate);
			}
			ReplaceTag("{PAGINATION}", $paginationtemplate, $output); //Add this pagination to the output
		}

		//Show new comment box when appropriate
		if(isset($singlemode))
		{
			$tags = [ 
				"{POSTID}" => $id,
				"{RECAPTCHAKEY}" => RECAPTCHA_PUBLIC_KEY
			];
			$newcommenttemplate = OpenTemplate("blognewcomment.tpl");
			ParseTags($tags, $newcommenttemplate);
			ReplaceTag("{NEWCOMMENTBOX}", $newcommenttemplate, $output); //Add the new comment box to the output
		}
		
		//Clean up the tags if not already replaced
		$cleantags = [ "{PAGEPREVIOUSLINK}", "{PAGEPREVIOUSTEXT}", "{PAGENEXTLINK}", "{PAGENEXTTEXT}", "{BLOGPOST}", "{PAGINATION}", "{COMMENT}", "{NEWCOMMENTBOX}" ];
		RemoveTags($cleantags, $output);
	}
}
?>