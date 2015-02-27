CREATE TABLE `blocked_addresses` (
  `address` varchar(130) DEFAULT NULL,
  `timestamp` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`address`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `blog_comments` (
  `commentID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `postID` int(11) unsigned DEFAULT NULL,
  `commentUsername` varchar(45) DEFAULT NULL,
  `commentText` varchar(1024) DEFAULT NULL,
  `commentTimestamp` int(10) unsigned DEFAULT NULL,
  `clientIP` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`commentID`),
  UNIQUE KEY `commentID_UNIQUE` (`commentID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `blog_posts` (
  `postID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `postTimestamp` int(11) DEFAULT NULL,
  `postTitle` varchar(255) DEFAULT NULL,
  `postContent` text,
  `postDraft` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`postID`),
  UNIQUE KEY `postID_UNIQUE` (`postID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `site_pages` (
  `pageID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pageName` varchar(10) DEFAULT NULL,
  `pageContent` text,
  `pageTitle` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`pageID`),
  UNIQUE KEY `pageID_UNIQUE` (`pageID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `site_users` (
  `username` varchar(45) NOT NULL,
  `password` varchar(512) NOT NULL,
  PRIMARY KEY (`username`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `site_tweets` (
  `tweetID` varchar(45) unsigned NOT NULL,
  `tweetTimestamp` text DEFAULT NULL,
  `tweetText` text NOT NULL,
  `tweetAvatar` text NOT NULL,
  `tweetName` varchar(45) NOT NULL,
  `tweetScreenname` varchar(45) NOT NULL,
  `tweetUpdatetime` varchar(45) NOT NULL,
  PRIMARY KEY (`tweetID`),
  UNIQUE KEY `tweetID_UNIQUE` (`tweetID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#Initial pages
INSERT INTO `site_pages` (`pageID`,`pageName`,`pageContent`,`pageTitle`) VALUES (1,'about','<p>Born, did fairly well at school, 3 years at college and didn\'t go to uni. Grew a passion for technology and engineering somewhere in between.</p>\n<p>&nbsp;</p>\n<p>When not buried in something electronic or covered in engine oil, Anthony enjoys all things Mountain Bike related, Golf and has an obsession with Formula 1.&nbsp;</p>\n<p>&nbsp;</p>\n<p>After growing up around workshops, vehicle parts and tools, Oil entered his bloodstream. Anthony enjoys building, fabricating, taking apart, fixing and tweaking. Be it Cars, Furniture, Buildings or anything in between.&nbsp;</p>\n<p>&nbsp;</p>\n<p>From an early age, Anthony grew a keen interest in Computing. Over the years, this developed and included a much wider range of technology. As a hobby grew into a career, a number of brainchild projects entered planning.&nbsp;</p>\n<p>Anthony took a leap of faith in 2013, launching his own UK Limited Company. This&nbsp;company now oversees the projects.&nbsp;</p>\n<p>&nbsp;</p>\n<p>He also has no problem speaking of himself in the third person.&nbsp;</p>\n<p>&nbsp;</p>\n<p>&nbsp;</p>\n<p>I do, however, have trouble telling people what I am good and bad at. In business terms, I have a very weak SWOT analysis.&nbsp;So here is and attempt at one of those:</p>\n<p style=\"text-align: center;\">&nbsp;<img src=\"../img/swot.png\" alt=\"SWOT Analysis\" width=\"512\" height=\"512\" /></p>\n<p>&nbsp;</p>','About Anthony');
INSERT INTO `site_pages` (`pageID`,`pageName`,`pageContent`,`pageTitle`) VALUES (2,'contact','<p>For general and business enquiries, please&nbsp;<a href=\"mailto:anthonyATa-birkett.co.uk\">Email me</a></p>\n<p>The above link is deliberately masked to prevent spam. Replace the AT symbol manually in your To: box.</p>\n<p>&nbsp;</p>\n<p>For questions and comments that you don\'t mind being public -&nbsp;<a href=\"https://twitter.com/intent/tweet?screen_name=birkett26\" target=\"_blank\">Tweet me!</a></p>\n<p>I am active on&nbsp;<a href=\"http://www.steamcommunity.com/id/birkett\" target=\"_blank\">Steam</a>&nbsp;and various forums around the internet.&nbsp;</p>','Contacting Anthony');
INSERT INTO `site_pages` (`pageID`,`pageName`,`pageContent`,`pageTitle`) VALUES (3,'photos','<p>From time to time, I may upload photographs of projects, or things of interest to me. Here are some randomly selected snaps. For the whole collection, be sure to <a href=\"http://www.flickr.com/users/birkett26\" target=\"_blank\">check my flickr account.</a></p>\n<!-- Start of Flickr Badge -->\n<script src=\"http://www.flickr.com/badge_code_v2.gne?count=10&amp;display=random&amp;size=m&amp;layout=x&amp;source=user&amp;user=114119465%40N04\"></script>\n<!-- End of Flickr Badge -->\n<p>&nbsp;</p>','Photos');
INSERT INTO `site_pages` (`pageID`,`pageName`,`pageContent`,`pageTitle`) VALUES (4,'videos','<p>The thoughts, ramblings and activities of life. For all videos, take a look at <a href=\"http://www.youtube.com/birkett26\" target=\"_blank\">my YouTube channel.</a></p>\n<p>&nbsp;</p>\n<p style=\"text-align: center;\"><iframe src=\"//www.youtube.com/embed/videoseries?list=PLN-BZXUNsLJDklBYrRAgO_lBAM5QFbokB\" width=\"560\" height=\"315\" frameborder=\"0\" allowfullscreen=\"\"></iframe></p>','Videos');
INSERT INTO `site_pages` (`pageID`,`pageName`,`pageContent`,`pageTitle`) VALUES (5,'projects','<p>This is a list of projects I am currently working on in some capacity. Some are single man efforts, others I am working as part of a team.&nbsp;</p>\n<p>&nbsp;</p>\n<p><a title=\"IT Lincs Ltd\" href=\"http://www.it-lincs.co.uk\" target=\"_blank\">IT Lincs Ltd</a>&nbsp;- My Project Company and front for personal business activities</p>\n<p><a title=\"Tantalum Customs\" href=\"http://www.tantalumcustoms.co.uk\" target=\"_blank\">Tantalum Customs</a>&nbsp;- Custom built PC\'s and hardware modding</p>\n<p><a title=\"The Live Home\" href=\"http://www.thelivehome.co.uk\" target=\"_blank\">The Live Home</a>&nbsp;- Internet connected devices and systems for a standardised Smart Home infrastructure</p>\n<p>&nbsp;</p>\n<p><a title=\"Mani Admin Plugin\" href=\"https://code.google.com/p/maniadminplugin/\" target=\"_blank\">Mani Admin Plugin</a>&nbsp;- Source Engine game server administration plugin</p>','Projects');
INSERT INTO `site_pages` (`pageID`,`pageName`,`pageContent`,`pageTitle`) VALUES (6,`404`,`<p>The requested page was not found, so <a href="../">how about my amazing homepage instead?</a></p>`,`That was a code 404...`);
