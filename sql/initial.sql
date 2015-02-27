/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2015 Anthony Birkett
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 *
 * Structured Query Language (SQL)
 *
 * @category  SQL
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */

# Create the table structure.

# address - IPv6 max length is 45 characters (180 bytes if unicode).
CREATE TABLE IF NOT EXISTS `blocked_addresses` (
  `address` varchar(180) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL,
  PRIMARY KEY (`address`),
  UNIQUE KEY `address_UNIQUE` (`address`)
) ENGINE=MyISAM DEFAULT CHARSET=UTF-8;

# commentUsername - Max of 25 characters accepted (100 bytes if unicode).
# commentText - Max of 1000 characters accepted (4000 bytes if unicode).
# clientIP - IPv6 max length is 45 characters (180 bytes if unicode).
CREATE TABLE IF NOT EXISTS `blog_comments` (
  `commentID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `postID` int(10) unsigned NOT NULL,
  `commentUsername` varchar(100) NOT NULL,
  `commentText` varchar(4000) NOT NULL,
  `commentTimestamp` int(10) unsigned NOT NULL,
  `clientIP` varchar(180) NOT NULL,
  PRIMARY KEY (`commentID`),
  UNIQUE KEY `commentID_UNIQUE` (`commentID`)
) ENGINE=MyISAM DEFAULT CHARSET=UTF-8;

# postTitle - Not limited in code, 70 chars is reasonable (280 bytes unicode).
# postContent - Not limited at all in code, try not to limit here by using TEXT.
# postDraft - boolean equivilant.
# postTweeted - boolean equivilant.
CREATE TABLE IF NOT EXISTS `blog_posts` (
  `postID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `postTimestamp` int(10) NOT NULL,
  `postTitle` varchar(280) NOT NULL,
  `postContent` text NOT NULL,
  `postDraft` tinyint(1) unsigned NOT NULL,
  `postTweeted` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`postID`),
  UNIQUE KEY `postID_UNIQUE` (`postID`)
) ENGINE=MyISAM DEFAULT CHARSET=UTF-8;

# pageName - Should be short, 10 chars is reasonable. (40 bytes unicode).
# pageContent - Try not to limit length by using TEXT.
# pageTitle - Not limited in code, 70 chars is reasonable (280 bytes unicode).
CREATE TABLE IF NOT EXISTS `site_pages` (
  `pageID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pageName` varchar(40) NOT NULL,
  `pageContent` text NOT NULL,
  `pageTitle` varchar(280) NOT NULL,
  PRIMARY KEY (`pageID`),
  UNIQUE KEY `pageID_UNIQUE` (`pageID`)
) ENGINE=MyISAM DEFAULT CHARSET=UTF-8;

# tweetID - Unique ID string. 25 characters (100 bytes unicode).
# tweetText - 140 characters (560 bytes if unicode).
# tweetAvatar - 250 characters for the URL is reasonable (1000 unicode bytes).
# tweetName - Unknown limit. Actual users name, 25 chars? (100 unicode bytes).
# tweetScreenname - Limited to 15 characters by Twitter (60 bytes unicode).
CREATE TABLE IF NOT EXISTS `site_tweets` (
  `tweetID` varchar(100) NOT NULL,
  `tweetTimestamp` int(10) NOT NULL,
  `tweetText` varchar(560) NOT NULL,
  `tweetAvatar` varchar(1000) NOT NULL,
  `tweetName` varchar(100) NOT NULL,
  `tweetScreenname` varchar(60) NOT NULL,
  `tweetFetchtime` int(10) NOT NULL,
  PRIMARY KEY (`tweetID`),
  UNIQUE KEY `tweetID_UNIQUE` (`tweetID`)
) ENGINE=MyISAM DEFAULT CHARSET=UTF-8;

# username - 25 characters (100 bytes if unicode).
# password - Hash might expand to 256 characters (200 bytes if unicode).
CREATE TABLE IF NOT EXISTS `site_users` (
  `username` varchar(45) NOT NULL,
  `password` varchar(1024) NOT NULL,
  PRIMARY KEY (`username`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=UTF-8;

#Initial pages
INSERT INTO `site_pages` (`pageID`,`pageName`,`pageContent`,`pageTitle`) VALUES (1,'about','<p>Born, did fairly well at school, 3 years at college and didn\'t go to uni. Grew a passion for technology and engineering somewhere in between.</p>\n<p>&nbsp;</p>\n<p>When not buried in something electronic or covered in engine oil, Anthony enjoys all things Mountain Bike related, Golf and has an obsession with Formula 1.&nbsp;</p>\n<p>&nbsp;</p>\n<p>After growing up around workshops, vehicle parts and tools, Oil entered his bloodstream. Anthony enjoys building, fabricating, taking apart, fixing and tweaking. Be it Cars, Furniture, Buildings or anything in between.&nbsp;</p>\n<p>&nbsp;</p>\n<p>From an early age, Anthony grew a keen interest in Computing. Over the years, this developed and included a much wider range of technology. As a hobby grew into a career, a number of brainchild projects entered planning.&nbsp;</p>\n<p>Anthony took a leap of faith in 2013, launching his own UK Limited Company. This&nbsp;company now oversees the projects.&nbsp;</p>\n<p>&nbsp;</p>\n<p>He also has no problem speaking of himself in the third person.&nbsp;</p>\n<p>&nbsp;</p>\n<p>&nbsp;</p>\n<p>I do, however, have trouble telling people what I am good and bad at. In business terms, I have a very weak SWOT analysis.&nbsp;So here is and attempt at one of those:</p>\n<p style=\"text-align: center;\">&nbsp;<img src=\"../img/swot.png\" alt=\"SWOT Analysis\" width=\"512\" height=\"512\" /></p>\n<p>&nbsp;</p>','About Anthony');
INSERT INTO `site_pages` (`pageID`,`pageName`,`pageContent`,`pageTitle`) VALUES (2,'contact','<p>For general and business enquiries, please&nbsp;<a href=\"mailto:anthonyATa-birkett.co.uk\">Email me</a></p>\n<p>The above link is deliberately masked to prevent spam. Replace the AT symbol manually in your To: box.</p>\n<p>&nbsp;</p>\n<p>For questions and comments that you don\'t mind being public -&nbsp;<a href=\"https://twitter.com/intent/tweet?screen_name=birkett26\" target=\"_blank\">Tweet me!</a></p>\n<p>I am active on&nbsp;<a href=\"http://www.steamcommunity.com/id/birkett\" target=\"_blank\">Steam</a>&nbsp;and various forums around the internet.&nbsp;</p>','Contacting Anthony');
INSERT INTO `site_pages` (`pageID`,`pageName`,`pageContent`,`pageTitle`) VALUES (3,'photos','<p>From time to time, I may upload photographs of projects, or things of interest to me. Here are some randomly selected snaps. For the whole collection, be sure to <a href=\"http://www.flickr.com/users/birkett26\" target=\"_blank\">check my flickr account.</a></p>\n<!-- Start of Flickr Badge -->\n<script src=\"http://www.flickr.com/badge_code_v2.gne?count=10&amp;display=random&amp;size=m&amp;layout=x&amp;source=user&amp;user=114119465%40N04\"></script>\n<!-- End of Flickr Badge -->\n<p>&nbsp;</p>','Photos');
INSERT INTO `site_pages` (`pageID`,`pageName`,`pageContent`,`pageTitle`) VALUES (4,'videos','<p>The thoughts, ramblings and activities of life. For all videos, take a look at <a href=\"http://www.youtube.com/birkett26\" target=\"_blank\">my YouTube channel.</a></p>\n<p>&nbsp;</p>\n<p style=\"text-align: center;\"><iframe src=\"//www.youtube.com/embed/videoseries?list=PLN-BZXUNsLJDklBYrRAgO_lBAM5QFbokB\" width=\"560\" height=\"315\" frameborder=\"0\" allowfullscreen=\"\"></iframe></p>','Videos');
INSERT INTO `site_pages` (`pageID`,`pageName`,`pageContent`,`pageTitle`) VALUES (5,'projects','<p>This is a list of projects I am currently working on in some capacity. Some are single man efforts, others I am working as part of a team.&nbsp;</p>\n<p>&nbsp;</p>\n<p><a title=\"IT Lincs Ltd\" href=\"http://www.it-lincs.co.uk\" target=\"_blank\">IT Lincs Ltd</a>&nbsp;- My Project Company and front for personal business activities</p>\n<p><a title=\"Tantalum Customs\" href=\"http://www.tantalumcustoms.co.uk\" target=\"_blank\">Tantalum Customs</a>&nbsp;- Custom built PC\'s and hardware modding</p>\n<p><a title=\"The Live Home\" href=\"http://www.thelivehome.co.uk\" target=\"_blank\">The Live Home</a>&nbsp;- Internet connected devices and systems for a standardised Smart Home infrastructure</p>\n<p>&nbsp;</p>\n<p><a title=\"Mani Admin Plugin\" href=\"https://code.google.com/p/maniadminplugin/\" target=\"_blank\">Mani Admin Plugin</a>&nbsp;- Source Engine game server administration plugin</p>','Projects');
INSERT INTO `site_pages` (`pageID`,`pageName`,`pageContent`,`pageTitle`) VALUES (6,'404','<p>The requested page was not found, so <a href="../">how about my amazing homepage instead?</a></p>','That was a code 404...');
