<!doctype html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta charset="utf-8" />
		<meta name="description" content="Personal website of Anthony Birkett, IT guy, Engineer and Entrepreneur.">
		<title>{TITLE}</title>
		<base href="{BASEURL}" />
		<link rel="alternate" href="/feed/" title="RSS feed" type="application/rss+xml" />
		<link rel="stylesheet" href="css/main.css" />
		{EXTRASTYLESHEETS}
		<link rel="stylesheet" href="css/christmas.css" />
		{/EXTRASTYLESHEETS}
		{ADMINSTYLESHEET}
		<link rel="stylesheet" href="{ADMINFOLDER}css/admin.css" />
		{/ADMINSTYLESHEET}
		<style type="text/css">
		.container { background-color: rgb({RAND2551},{RAND2552},{RAND2553}); }
		.leftc { background-image:url("img/background_figure_{RAND12}.png"); }
		</style>
	</head>
	<body>
		<div class="container">
			<div class="header">
				<a href="/{ADMINFOLDER}"><h1>Anthony <strong>Birkett</strong></h1></a>
				<a href="http://www.twitter.com/birkett26" title="Twitter" target="_blank"><img class="headernavicon" src="img/twitter.png" alt="twitter" /></a>
				<a href="http://www.github.com/birkett" title="GitHub" target="_blank"><img class="headernavicon" src="img/github.png" alt="github" /></a>
				<a href="http://www.steamcommunity.com/id/birkett" title="Steam" target="_blank"><img class="headernavicon" src="img/steam.png" alt="steam" /></a>
				<a href="http://www.youtube.com/birkett26" title="YouTube" target="_blank"><img class="headernavicon" src="img/youtube.png" alt="youtube" /></a>
				<a href="http://www.flickr.com/photos/birkett26" title="Flickr" target="_blank"><img class="headernavicon" src="img/flickr.png" alt="flickr" /></a>
				<a href="{BASEURL}feed" title="Blog Feed" target="_blank"><img class="headernavicon" src="img/rss.png" alt="feed" /></a>
			</div>
			<div class="fadeout"></div>
			<div class="noticebox"></div>
			<div class="content">
				{PAGE}
			</div>
			<div class="widgetcontainer">
				<div class="fadein"></div>
				<div class="post">
					{WIDGET}
				</div>
				<div class="fadeout"></div>
			</div>
			<div class="fadein"></div>
			<div class="footer">
				<p>&copy; 2007-{THISYEAR} Anthony Birkett</p>
				<ins class="adsbygoogle" data-ad-client="ca-pub-3491498523960183" data-ad-slot="5861200158"></ins>
				<div class="fadeblack"></div>
			</div>
		</div>
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
		</script>
	</body>
</html>
