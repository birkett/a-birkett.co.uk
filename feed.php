<?php
//-----------------------------------------------------------------------------
// Blog syndication feed
//
//  Generates an RSS feed for the blog
//-----------------------------------------------------------------------------
require_once("config.php");
require_once("classes/database.class.php");
require_once("functions.php");

header("Content-Type: application/rss+xml; charset=utf-8");


echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<rss version="2.0">';
echo '<channel>';
echo '<title>' . SITE_TITLE . ' :: Blog Posts</title>';
echo '<link>' . BASE_URL . '</link>';
echo '<description>RSS feed for the personal blog of ' . SITE_TITLE . '</description>';
echo '<language>en-GB</language>';
echo '<copyright>&copy; 2007-' . date('Y') . ' Anthony Birkett - ' . BASE_URL . '</copyright>';

$result = GetLatestPosts(1);
while($row = GetDatabase()->GetRow($result)) //Get first page of posts
{
	list($id, $timestamp, $title, $content, $draft) = $row;
	echo '<item>';
	echo '<title>' . $title . '</title>';
	echo '<description>' . $content . '</description>';
	echo '<link>' . BASE_URL . "/blog/" . $id . '</link>';
	echo '<pubDate>' . date("D, d M Y H:i:s O", $timestamp) . '</pubDate>';
	echo '</item>';
}
					 
echo '</channel>';
echo '</rss>';
?>