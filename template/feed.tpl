<?xml version="1.0" encoding="utf-8"?>
    <rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <atom:link href="{BASEURL}feed" rel="self" type="application/rss+xml" />
        <title>{TITLE}</title>
        <link>{BASEURL}</link>
        <description>RSS feed for the personal blog of Anthony Birkett.</description>
        <language>en-GB</language>
        <copyright>Copyright (C) 2007-{THISYEAR} Anthony Birkett - {BASEURL}</copyright>

        {LOOP}
        <item>
            <title>{POSTTITLE}</title>
            <description><![CDATA[{POSTCONTENT}]]></description>
            <link>{BASEURL}blog/{POSTID}</link>
            <pubDate>{POSTTIMESTAMP}</pubDate>
            <guid isPermaLink="false">{POSTTIMESTAMP}</guid>
        </item>
        {/LOOP}
    </channel>
</rss>
