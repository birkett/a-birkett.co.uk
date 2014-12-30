<?php
//-----------------------------------------------------------------------------
// Build the post list widget
//		In: Unparsed template
//		Out: Parsed template
//-----------------------------------------------------------------------------
class PostsWidgetController
{
	public function __construct(&$output)
	{
		$posts = GetPosts("all");
		$monthloop = LogicTag("{MONTHLOOP}", "{/MONTHLOOP}", $output);
		$itemloop = LogicTag("{ITEMLOOP}", "{/ITEMLOOP}", $output);
		$post_array = [];
		while(list($id, $timestamp, $title, $draft) = GetDatabase()->GetRow($posts))
		{
			$month = date("F Y", $timestamp);
			if(!isset($post_array["$month"]))
				$post_array["$month"] = [];
			array_push($post_array["$month"], [ "title" => $title, "id" => $id ]);
		}
		
		foreach($post_array as $month => $data)
		{
			$temp = $monthloop;
			$tags = [ "{MONTH}" => $month ];
			ParseTags($tags, $temp);
			foreach($data as $post)
			{
				$temp2 = $itemloop;
				$tags = [
					"{POSTID}" => $post['id'],
					"{POSTTITLE}" => $post['title']
				];
				ParseTags($tags, $temp2);
				$temp2 .= "{ITEMS}";
				ReplaceTag("{ITEMS}", $temp2, $temp);
			}
			$temp .= "{MONTHS}";
			ReplaceTag("{MONTHS}", $temp, $output);
			RemoveLogicTag("{ITEMLOOP}", "{/ITEMLOOP}", $output);
		}
		RemoveLogicTag("{MONTHLOOP}", "{/MONTHLOOP}", $output);
		$tags = [ "{ITEMS}", "{MONTHS}" ];
		RemoveTags($tags, $output);
	}
}
?>