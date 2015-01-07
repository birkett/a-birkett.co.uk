<?php
//-----------------------------------------------------------------------------
// Blog syndication feed
//
//  Generates an RSS feed for the blog
//-----------------------------------------------------------------------------
require_once("config.php");
require_once("classes/pdomysql.database.class.php");
require_once("functions.php");

PHPDefaults();

header("Content-Type: application/xml; charset=utf-8");

echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">';
echo '<channel>';
echo '<atom:link href="' . BASE_URL . 'feed" rel="self" type="application/rss+xml" />';
echo '<title>' . SITE_TITLE . ' :: Blog Posts</title>';
echo '<link>' . BASE_URL . '</link>';
echo '<description>RSS feed for the personal blog of ' . SITE_TITLE . '</description>';
echo '<language>en-GB</language>';
echo '<copyright>Copyright (C) 2007-' . date('Y') . ' Anthony Birkett - ' . BASE_URL . '</copyright>';

$result = GetPosts("page", 0, false); //Get first page of posts
while (list($id, $timestamp, $title, $content, $draft) = GetDatabase()->GetRow($result)) {
    echo '<item>';
    echo '<title>' . $title . '</title>';
    echo '<description><![CDATA[' . html_entity_decode($content) . ']]></description>';
    echo '<link>' . BASE_URL . "blog/" . $id . '</link>';
    echo '<pubDate>' . date("D, d M Y H:i:s O", $timestamp) . '</pubDate>';
    echo '<guid isPermaLink="false">' . date("D, d M Y H:i:s O", $timestamp) . '</guid>'; //Using the timestamp as GUID
    echo '</item>';
}

echo '</channel>';
echo '</rss>';
