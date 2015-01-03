<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="description" content="Personal website of Anthony Birkett, IT guy, Engineer and Entrepreneur.">
		<title>{TITLE}</title>
		<base href="{BASEURL}" />
		<link rel="alternate" href="/feed/" title="RSS feed" type="application/rss+xml" />
		<link rel="stylesheet" href="css/main.css" />
		{EXTRASTYLESHEETS}
		<link rel="stylesheet" href="css/christmas.css" />
		{/EXTRASTYLESHEETS}
		<style type="text/css">
		.container { background-color: rgb({RAND2551},{RAND2552},{RAND2553}); }
		.leftc { background-image:url("img/background_figure_{RAND12}.png"); }
		</style>
	</head>
	<body>
		<div class="container">
			<div class="header">
				<a href="/"><h1>Anthony <strong>Birkett</strong></h1></a>
				<a href="http://www.twitter.com/birkett26" title="Twitter" target="_blank"><img class="headernavicon" src="img/twitter.png" alt="twitter" /></a>
				<a href="http://www.steamcommunity.com/id/birkett" title="Steam" target="_blank"><img class="headernavicon" src="img/steam.png" alt="steam" /></a>
				<a href="http://www.youtube.com/birkett26" title="YouTube" target="_blank"><img class="headernavicon" src="img/youtube.png" alt="youtube" /></a>
				<a href="http://www.flickr.com/photos/birkett26" title="Flickr" target="_blank"><img class="headernavicon" src="img/flickr.png" alt="flickr" /></a>
				<a href="{BASEURL}feed" title="Blog Feed" target="_blank"><img class="headernavicon" src="img/rss.png" alt="feed" /></a>
			</div>
			<div class="headerborder"></div>
			<div class="noticebox"></div>
			<div class="post">
				{PAGE}
			</div>
			<div class="widgetcontainer">
				<div class="aero">
					{WIDGET.old}
				</div>
			</div>
			<div class="footerborder"></div>
			<div class="footer">
				<p>&copy; 2007-{THISYEAR} Anthony Birkett</p>
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px" data-ad-client="ca-pub-3491498523960183" data-ad-slot="5861200158"></ins>
				<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
				</script>		
				<div class="footerfade"></div>
			</div>
		</div>
	</body>
</html>