<?php
//-----------------------------------------------------------------------------
// Build the post list widget
//		In: Unparsed template
//		Out: Parsed template
//  TODO: This is the only non pure PHP function. Move the HTML out?
//-----------------------------------------------------------------------------
class PostsWidgetController
{
	public function __construct(&$output)
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
		ReplaceTag("{POSTLIST}", $postlist, $output);
	}
}
?>