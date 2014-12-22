<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="description" content="Personal website of Anthony Birkett, IT guy, Engineer and Entrepreneur.">
		<title><?php echo $title; ?></title>
		<base href="<?php echo BASE_URL ?>" />
		<link rel="stylesheet" href="css/main.css" />
		<?php if(CHRISTMAS) { echo '<link rel="stylesheet" href="css/christmas.css" />' . "\n"; } ?>
		
		<style type="text/css">
		.container { background-color: rgb(<?php echo rand(0,255); ?>,<?php echo rand(0,255); ?>,<?php echo rand(0,255); ?>); }
		.leftc { background-image:url("img/background_figure_<?php echo rand(1,2); ?>.png"); }
		</style>
	</head>
	<body>
		<div class="container pngfix">
			<div class="header pngfix">
				<div class="headerleft">
					<a href="/"><h1>Anthony <strong>Birkett</strong></h1></a>
				</div>
				<div class="headerright">
					<a href="http://www.twitter.com/birkett26" alt="twitter" title="Twitter" target="_blank"><img class="headernavicon pngfix" src="img/twitter.png" alt="twitter" /></a>
					<a href="http://www.steamcommunity.com/id/birkett" alt="steam" title="Steam" target="_blank"><img class="headernavicon pngfix" src="img/steam.png" alt="steam" /></a>
					<a href="http://www.youtube.com/birkett26" alt="youtube" title="YouTube" target="_blank"><img class="headernavicon pngfix" src="img/youtube.png" alt="youtube" /></a>
					<a href="http://www.flickr.com/photos/birkett26" alt="flickr" title="Flickr" target="_blank"><img class="headernavicon pngfix" src="img/flickr.png" alt="flickr" /></a>
				</div>
			</div>
			<div class="main">
				<div class="leftc pngfix">
				</div>
				<div class="rightcontainer">
				