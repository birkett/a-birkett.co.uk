CREATE TABLE `blocked_addresses` (
  `ip_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `address` varchar(130) DEFAULT NULL,
  `blocked_timestamp` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`ip_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `blog_comments` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(11) unsigned DEFAULT NULL,
  `comment_username` varchar(45) DEFAULT NULL,
  `comment_text` varchar(1024) DEFAULT NULL,
  `comment_timestamp` int(10) unsigned DEFAULT NULL,
  `client_ip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`comment_id`),
  UNIQUE KEY `comment_id_UNIQUE` (`comment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `blog_posts` (
  `post_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_timestamp` int(11) DEFAULT NULL,
  `post_title` varchar(255) DEFAULT NULL,
  `post_content` text,
  `post_draft` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`post_id`),
  UNIQUE KEY `post_id_UNIQUE` (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `site_pages` (
  `page_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page_name` varchar(10) DEFAULT NULL,
  `page_content` text,
  `page_title` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`page_id`),
  UNIQUE KEY `page_id_UNIQUE` (`page_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `site_users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id_UNIQUE` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#Initial pages
INSERT INTO `site_pages` (`page_id`,`page_name`,`page_content`,`page_title`) VALUES (1,'about','<p>Born, did fairly well at school, 3 years at college and didn\'t go to uni. Grew a passion for technology and engineering somewhere in between.</p>\n<p>&nbsp;</p>\n<p>When not buried in something electronic or covered in engine oil, Anthony enjoys all things Mountain Bike related, Golf and has an obsession with Formula 1.&nbsp;</p>\n<p>&nbsp;</p>\n<p>After growing up around workshops, vehicle parts and tools, Oil entered his bloodstream. Anthony enjoys building, fabricating, taking apart, fixing and tweaking. Be it Cars, Furniture, Buildings or anything in between.&nbsp;</p>\n<p>&nbsp;</p>\n<p>From an early age, Anthony grew a keen interest in Computing. Over the years, this developed and included a much wider range of technology. As a hobby grew into a career, a number of brainchild projects entered planning.&nbsp;</p>\n<p>Anthony took a leap of faith in 2013, launching his own UK Limited Company. This&nbsp;company now oversees the projects.&nbsp;</p>\n<p>&nbsp;</p>\n<p>He also has no problem speaking of himself in the third person.&nbsp;</p>\n<p>&nbsp;</p>\n<p>&nbsp;</p>\n<p>I do, however, have trouble telling people what I am good and bad at. In business terms, I have a very weak SWOT analysis.&nbsp;So here is and attempt at one of those:</p>\n<p style=\"text-align: center;\">&nbsp;<img src=\"../img/swot.png\" alt=\"SWOT Analysis\" width=\"512\" height=\"512\" /></p>\n<p>&nbsp;</p>','About Anthony');
INSERT INTO `site_pages` (`page_id`,`page_name`,`page_content`,`page_title`) VALUES (2,'contact','<p>For general and business enquiries, please&nbsp;<a href=\"mailto:anthonyATa-birkett.co.uk\">Email me</a></p>\n<p>The above link is deliberately masked to prevent spam. Replace the AT symbol manually in your To: box.</p>\n<p>&nbsp;</p>\n<p>For questions and comments that you don\'t mind being public -&nbsp;<a href=\"https://twitter.com/intent/tweet?screen_name=birkett26\" target=\"_blank\">Tweet me!</a></p>\n<p>I am active on&nbsp;<a href=\"http://www.steamcommunity.com/id/birkett\" target=\"_blank\">Steam</a>&nbsp;and various forums around the internet.&nbsp;</p>','Contacting Anthony');
INSERT INTO `site_pages` (`page_id`,`page_name`,`page_content`,`page_title`) VALUES (3,'photos','<p>From time to time, I may upload photographs of projects, or things of interest to me. Here are some randomly selected snaps. For the whole collection, be sure to <a href=\"http://www.flickr.com/users/birkett26\" target=\"_blank\">check my flickr account.</a></p>\n<!-- Start of Flickr Badge -->\n<script src=\"http://www.flickr.com/badge_code_v2.gne?count=10&amp;display=random&amp;size=m&amp;layout=x&amp;source=user&amp;user=114119465%40N04\"></script>\n<!-- End of Flickr Badge -->\n<p>&nbsp;</p>','Photos');
INSERT INTO `site_pages` (`page_id`,`page_name`,`page_content`,`page_title`) VALUES (4,'videos','<p>The thoughts, ramblings and activities of life. For all videos, take a look at <a href=\"http://www.youtube.com/birkett26\" target=\"_blank\">my YouTube channel.</a></p>\n<p>&nbsp;</p>\n<p style=\"text-align: center;\"><iframe src=\"//www.youtube.com/embed/videoseries?list=PLN-BZXUNsLJDklBYrRAgO_lBAM5QFbokB\" width=\"560\" height=\"315\" frameborder=\"0\" allowfullscreen=\"\"></iframe></p>','Videos');
INSERT INTO `site_pages` (`page_id`,`page_name`,`page_content`,`page_title`) VALUES (5,'projects','<p>This is a list of projects I am currently working on in some capacity. Some are single man efforts, others I am working as part of a team.&nbsp;</p>\n<p>&nbsp;</p>\n<p><a title=\"IT Lincs Ltd\" href=\"http://www.it-lincs.co.uk\" target=\"_blank\">IT Lincs Ltd</a>&nbsp;- My Project Company and front for personal business activities</p>\n<p><a title=\"Tantalum Customs\" href=\"http://www.tantalumcustoms.co.uk\" target=\"_blank\">Tantalum Customs</a>&nbsp;- Custom built PC\'s and hardware modding</p>\n<p><a title=\"The Live Home\" href=\"http://www.thelivehome.co.uk\" target=\"_blank\">The Live Home</a>&nbsp;- Internet connected devices and systems for a standardised Smart Home infrastructure</p>\n<p>&nbsp;</p>\n<p><a title=\"Mani Admin Plugin\" href=\"https://code.google.com/p/maniadminplugin/\" target=\"_blank\">Mani Admin Plugin</a>&nbsp;- Source Engine game server administration plugin</p>','Projects');
