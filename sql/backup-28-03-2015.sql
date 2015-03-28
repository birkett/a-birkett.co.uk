/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `blocked_addresses`
--

DROP TABLE IF EXISTS `blocked_addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blocked_addresses` (
  `address` varchar(180) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL,
  PRIMARY KEY (`address`),
  UNIQUE KEY `address_UNIQUE` (`address`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blocked_addresses`
--

LOCK TABLES `blocked_addresses` WRITE;
/*!40000 ALTER TABLE `blocked_addresses` DISABLE KEYS */;
/*!40000 ALTER TABLE `blocked_addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_comments`
--

DROP TABLE IF EXISTS `blog_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_comments` (
  `commentID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `postID` int(10) unsigned NOT NULL,
  `commentUsername` varchar(100) NOT NULL,
  `commentText` varchar(4000) NOT NULL,
  `commentTimestamp` int(10) unsigned NOT NULL,
  `clientIP` varchar(180) NOT NULL,
  PRIMARY KEY (`commentID`),
  UNIQUE KEY `commentID_UNIQUE` (`commentID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_comments`
--

LOCK TABLES `blog_comments` WRITE;
/*!40000 ALTER TABLE `blog_comments` DISABLE KEYS */;
INSERT INTO `blog_comments` VALUES (1,1,'Anthony','A quick test comment to make sure we are up and running!',1397732475,'82.22.235.33'),(2,3,'Kev','On the contrary though, I spend ┬ú86 a year on my motorbike insurance! Just thought that would make you hate me a little more.',1397911105,'213.105.53.241'),(3,1,'Anthony','Another quick test to make sure everything is working after the upgrade!',1427473151,'82.22.235.33');
/*!40000 ALTER TABLE `blog_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_posts`
--

DROP TABLE IF EXISTS `blog_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_posts` (
  `postID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `postTimestamp` int(10) NOT NULL,
  `postTitle` varchar(280) NOT NULL,
  `postContent` text NOT NULL,
  `postDraft` tinyint(1) unsigned NOT NULL,
  `postTweeted` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`postID`),
  UNIQUE KEY `postID_UNIQUE` (`postID`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_posts`
--

LOCK TABLES `blog_posts` WRITE;
/*!40000 ALTER TABLE `blog_posts` DISABLE KEYS */;
INSERT INTO `blog_posts` VALUES (1,1397732412,'Hello World','<p>It seems like such a long time ago when I actually had a website. This domain has been through various incarnations since 2006, eventually hosting a place-holder page from 2009 to 2013. I just didn\'t have the need for anything more.&nbsp;</p>\n<p>Things changed. Now I needed a hub to share my work, and occasionally, thoughts. It was time to regain some presence.&nbsp;</p>\n<p>&nbsp;</p>\n<p>I looked at WordPress (used here in 2006),&nbsp;Drupal and even the old e107 (loads of experience with this one back in the day!). But, if you have already read my <a title=\"About Me\" href=\"../about\" target=\"_blank\">About Me Page</a>, you know I\'m not one for off the shelf solutions.&nbsp;</p>\n<p>So I built a basic CMS and Blog system. I like it. It\'s clean, simple and easy to expand if needed. The whole site is less than 1500 lines of code, about 75% PHP. I\'m going to be calling in some help from a friend for the fancier graphics and arty stuff!</p>\n<p>&nbsp;</p>\n<p>Over the next few days, I will be posting up some of my old posts which are relevant. A bit of a blast from the past to launch with.</p>\n<p>&nbsp;</p>\n<p>So, Hello World, and welcome. I do hope there will be something interesting here for you!</p>',0,1),(2,1397748938,'Nokia N95','<p><em>From the archives. This was originally posted on the 27th September 2011. Shortly after this, I changed to a HP/Palm Pre3, which I am still using.&nbsp;</em></p>\n<p>&nbsp;</p>\n<p><a href=\"https://www.flickr.com/photos/birkett26/13888836611/in/photostream/\" target=\"_blank\"><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"https://farm8.staticflickr.com/7117/13888836611_f15aea05f2.jpg\" alt=\"N95 8GB\" width=\"500\" height=\"263\" /></a></p>\n<p>I like reviewing things. I find I can talk for hours about how that circular thing rotates along a 270 degree plane, only to return to its initial position with a satisfying spring loaded action. Not too much spring, just enough to give a satisfying feel of quality. It&rsquo;s a stainless steel circular thing by the way.</p>\n<p>&nbsp;</p>\n<p>It may sound strange to be reviewing a 4 year old phone, but for reasons that will become apparent, this is the most appropriate way. I don&rsquo;t understand how &ldquo;reviewers&rdquo; can give an honest opinion of a product having only used it for a few days prior to the review. I find that the outcome usually goes along the lines of &ldquo;I didn&rsquo;t get the chance to use this to its full potential, but generally I didn&rsquo;t like it&rdquo; or &ldquo;I love it, buy one&rdquo;.</p>\n<p>&nbsp;</p>\n<p>I have used this phone every day for 3 and a half years, 1,213 days to be precise. I believe that is long enough to give an honest opinion, of all features.</p>\n<p>&nbsp;</p>\n<p>Before the N95, I was a proud owner of a Samsung E900. Not the fanciest of phones looking back, but still served me well. An unfortunate smelting charging accident left it somewhat limited in use. That left me phone shopping for a day or two.&nbsp;</p>\n<p>I had been looking at these new-fangled &ldquo;smartphones&rdquo; that seemed to be gaining a reputation at the time. Touch screens had not yet made a big break into the phone world and built in WiFi was something still limited to only the most up-market phones and PDA&rsquo;s.</p>\n<p>&nbsp;</p>\n<p>When phone buying, I look for something that will last. I don&rsquo;t mind putting in a comparably large investment if it will last. I don&rsquo;t tend to follow the crowd (I have a habit of hating most of the popular gadgets), I look for quality and features. So along comes the N95 and the N95 8GB, modestly taking its place at the top of the smartphone market. It certainly didn&rsquo;t come in cheap, but it packed almost all of the cutting edge features at the time into a form factor that became a landmark icon for Nokia. To this day, I no other phone comes to mind that has a two way slide.</p>\n<p>&nbsp;</p>\n<p>I remember unboxing the N95, which Nokia seems to make an enjoyable experience. I got my N95 from 3 UK, so it came with the usual carrier locks and branded firmware. However, 3 kept all the packaging vanilla. The phone came packaged with a USB cable, mains charger, TV output cable, Driver CD, earphones and documentation. I&rsquo;m not a believer in reading the Quick Start guides, so I jammed in a SIM card and went for it.</p>\n<p>&nbsp;</p>\n<p>The first boot took an age. It wasn&rsquo;t even a user friendly age, a white screen, no icons, no back light, nothing. I now know that this is normal on first boot, or after a reset &ndash; but still &ndash; an animated boot splash couldn&rsquo;t have gone a miss.</p>\n<p>Initial set up was quick and easy, the usual time / date and language choices. Network APN&rsquo;s and message gateways where automagically set up for me, so I could start using the phone immediately.</p>\n<p>&nbsp;</p>\n<p>It took me a few days to get used to things, notably the different space key placement, one of the finer details of moving from Samsung to Nokia.</p>\n<p>For its time, the battery life wasn&rsquo;t great. I was pressed to get 3 days moderate use out of it before having the phone refuse to turn back on. The old E900 was quite frugal on power, regularly turning back on when all the indicators said 0%.</p>\n<p>&nbsp;</p>\n<p>&nbsp;</p>\n<p>Zoom forward over 1000 days, the old faithful is still going strong. Not once have I been disappointed by lack of features compared to modern phones. The camera keeps up with the newer Sony Ericsson CyberShot (I&rsquo;ve compared with the K850i, C902 and W995). To be fair, there is a difference. For a quick photo to remember something (which is what phone cameras are for?) the N95 will still hold its own, even against dedicated digital cameras. Start talking about Full-HD recording and bi-directional microphones, then I&rsquo;m in second place.</p>\n<p>&nbsp;</p>\n<p>WiFi has always been reliable for me, Bluetooth has never put a foot wrong. GPS on the other hand has been a nightmare. I have never been able to get it to reliably connect, making the N95 as a navigation device quite useless.</p>\n<p>Call and audio quality has been fantastic, loud speakers still pack enough power for most scenarios.</p>\n<p>&nbsp;</p>\n<p>I use the N95 for SMS (texting), a lot. The only issue I have ever had, is with the inbox. Once you have more that 1500 messages stored in there, things become noticeably sluggish. Simple fix though, move the messages to &ldquo;My Folders&rdquo;, or simply delete them. (On this note, I have found <a title=\"ABC Amber NBU Converter\" href=\"http://www.processtext.com/abcnbu.html\" target=\"_blank\">ABC Amber NBU Converter</a>&nbsp;an invaluable tool for extracting and archiving messages from a Nokia backup file)</p>\n<p>&nbsp;</p>\n<p>My biggest observation about this phone after a few years though, the build quality. Yes, it&rsquo;s a bit battered and bruised on the back &ndash; but the slide is still tight, the buttons and keypad still feel sharp and nothing has fallen off or chipped. About 6 months ago, it even got wet, to the point where it decided to switch itself off. 2 hours later, having removed the battery and let it roast on a radiator, it fires back into life no problem. I am disappointed though, it asked me for the time and date!</p>\n<p>&nbsp;</p>\n<p>Symbian has continued to be sub-par next to its rivals, Nokia Ovi has been an attempt to change this &ndash; but has sadly gained a rather bad reputation.</p>\n<p>&nbsp;</p>\n<p>4 years after release, this phone is showing it&rsquo;s age. It is for that reason, and that reason alone &ndash; I sadly cannot recommend this phone to people any more. It&rsquo;s a fantastic phone, it has served me well for a very long time, but it&rsquo;s time to be retired.</p>\n<p>&nbsp;</p>\n<p>Well done Nokia, you created a phone that has become a deserving icon for your company.</p>',0,1),(3,1397905069,'Car Insurance','<p><em>From the archives. This was originally posted on the 28th July 2011.&nbsp;The situation hasn\'t improved much since then.</em></p>\n<p>&nbsp;</p>\n<p><a href=\"https://www.flickr.com/photos/birkett26/13912358893/\" target=\"_blank\"><em><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"https://farm8.staticflickr.com/7033/13912358893_ec95b1d6cb.jpg\" alt=\"Corsa C 1.0 2006\" width=\"500\" height=\"291\" /></em></a></p>\n<p>&nbsp;</p>\n<p>What follows is a rant, aimed at UK car insurers &ndash; expressing my disgust, anger and thought process that concludes with the words &ldquo;Scamming bastards&rdquo;.</p>\n<p>&nbsp;</p>\n<p>I\'m still a relatively young driver, own a car popularised by hooligans, and generally tick the boxes that rake in the money for insurers. But when you get a renewal quote through, which is more expensive than your first year&rsquo;s policy on a provisional licence, as a student &ndash; eyebrows raise.</p>\n<p>&nbsp;</p>\n<p>It gets better when you start getting quotes from other companies. One wanted to charge me just over the total value of the car, another wanted less than half my renewal quote. It&rsquo;s like these people just pull arbitrary numbers out of their money shitting arseholes.</p>\n<p>&nbsp;</p>\n<p>I have my no claims bonus, drive sensibly, look after the car and have a regular income. Why then, is it such a problem to offer me a decent premium based on me &ndash; not the drivers causing accidents and fraudulently claiming? Look at it this way insurers: chances are, my policy will never need to pay out. It&rsquo;s pure profit for you.</p>\n<p>&nbsp;</p>\n<p>Needless to say, I went with the most sensible quote, got windscreen cover, legal protection and Business Class 1 included for next to nothing. I\'m quite happy with the Nationwide right now. I can&rsquo;t say that for the likes of Quinn Direct and others who are charging extortionate prices, not even attempting to be competitive.</p>\n<p>Scamming bastards.</p>\n<p>&nbsp;</p>',0,1),(5,1404388009,'Tips for running CyanogenMod on a Galaxy S (i9000)','<p><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"http://farm6.staticflickr.com/5505/14561090361_218dbcb08b_b.jpg\" alt=\"AndroidBatter\" width=\"800\" height=\"300\" /></p>\n<p><a title=\"CyanogenMod\" href=\"http://www.cyanogenmod.org\" target=\"_blank\">CyanogenMod </a>is fantastic. Android 4.4 on an old device works perfectly well, with a few tweaks:</p>\n<p>&nbsp;</p>\n<ul>\n<li>Don\'t flash&nbsp;Google Apps. <a title=\"XDA-Developers Forum Thread\" href=\"http://forum.xda-developers.com/showthread.php?t=1996995\" target=\"_blank\">Side load only the Play store</a>, then install anything else you need later.&nbsp;</li>\n<li>Disable the voice search:&nbsp;<strong>Settings-&gt;Apps-&gt;All and disable \"Sound Search for Google Play\"</strong>. This was causing me no end of trouble.&nbsp;</li>\n<li>Disable KSM. <strong>Settings-&gt;Performance-&gt;Memory Management-&gt;Kernel Samepage Merging</strong>. KSMD was killing the CPU for me (15% usage, all the time).</li>\n<li>Set the I/O Scheduler and Processor Governor. <strong>Settings-&gt;Performance</strong>. I/O Scheduler set to NOOP, feels much snappier. Processor Governor set to Interactive. You can also up the maximum clock speed to 1.2ghz from here.</li>\n<li>Set up ART (Android Runtime) instead of Dalvik. <strong>Settings-&gt;Developer Options-&gt;Select Runtime-&gt;Use ART</strong>.</li>\n<li>Disable Facebook notifications.<strong> Facebook-&gt;App Settings-&gt;Turn it all off.</strong> Not only is it annoying, it destroyed my battery.</li>\n<li>Reduce the animation timescales, <strong>Settings-&gt;Developer options-&gt;Transition, Animator and Duration scale to 0.5x</strong></li>\n</ul>\n<p>&nbsp;&nbsp;</p>\n<p>I can\'t say if all of this is good advice, maybe it isn\'t! But it\'s working out great for me.</p>\n<p>&nbsp;</p>\n<p>I\'m now officially on an Android adventure. I would love to get a more modern kernel running for the i9000 (and the other devices that share the Aries platform). Currently, 3.0.101 is the end of the road, but I think with some hacking, 3.10 should work (Google AOSP have a 3.10.x branch).&nbsp;</p>',0,1),(4,1403097903,'My programming process','<p>I don\'t write code once, I write it 5 times, through iteration.&nbsp;</p>\n<p>This applies to everything, PHP, C++, even Batch.</p>\n<p>&nbsp;</p>\n<p><strong>1st time: Make something that works.&nbsp;</strong></p>\n<p>This is the best code in the world, because it works.&nbsp;</p>\n<p>&nbsp;</p>\n<p><strong>2nd time: Make it safe.</strong></p>\n<p>This is the new best code in the world, because it works, and doesn\'t have any massive security flaws.&nbsp;</p>\n<p>&nbsp;</p>\n<p><strong>3rd time: Make it fast.</strong></p>\n<p>Now we have awesome code, it\'s working, it\'s safe and it\'s efficient.&nbsp;</p>\n<p>&nbsp;</p>\n<p><strong>4th time: Make it readable.</strong></p>\n<p>I\'m really good&nbsp;at writing poorly formatted code. When I get to the 4th iteration, I fix that.&nbsp;</p>\n<p>&nbsp;</p>\n<p><strong>5th time:&nbsp;Future thinking.</strong></p>\n<p>Code needs to be easy to modify. If I forgot about an interface somewhere, or hard coded something that should ideally be user changeable, it gets sorted.&nbsp;</p>',0,1),(7,1404995286,'Hard Drive Testing','<p>I needed some extra storage in my workstation. Coffee, stack of drives and a bunch of objective testing later - we have a winner.</p>\n<p><iframe class=\"youtube\" src=\"//www.youtube.com/embed/7q1QVtPHiwc\"></iframe></p>',0,1),(8,1406127791,'CloudFlare Dynamic DNS','<p>For the past 3 years, I have been using the DynDNS paid service for my Dynamic DNS needs. Before that, I was using their free service, and even before that, No-IP.</p>\n<p>As you may (or may not) have seen, earlier this year -&nbsp;<a href=\"http://dyn.com/blog/why-we-decided-to-stop-offering-free-accounts/\" target=\"_blank\">Dyn shut down their free service.&nbsp;</a></p>\n<p>This didn\'t effect me, I was part of the elite paid members club. But it did rather annoy me, because that same free service, was perfect for so many people.</p>\n<p>&nbsp;</p>\n<p>I don\'t feel good about supporting a company which leaves so many people dead in the water, so, I won\'t be renewing on my Dyn account this year.&nbsp;</p>\n<p>Instead, I\'ve moved everything over to&nbsp;<a href=\"http://www.cloudflare.com\" target=\"_blank\">CloudFlare.</a>&nbsp;Now, CloudFlare don\'t really advertise their Dynamic DNS offerings, but they exist, and they are free!</p>\n<p>&nbsp;</p>\n<p>The nature of how CloudFlare works to mitigate&nbsp;DOS attacks and provide traffic monitoring, lends itself perfectly to DDNS.</p>\n<p>So when you set up a domain, you have some really attractive TTL values, down to 5mins.&nbsp;</p>\n<p>&nbsp;</p>\n<p>Oooh, and they have an <a href=\"https://www.cloudflare.com/docs/client-api.html\" target=\"_blank\">awesome API</a>&nbsp;to control the record updates.</p>\n<p>&nbsp;</p>\n<p>If you\'re using Linux, CloudFlare offer a modified ddclient for performing the updates. Windows offerings are somewhat sparse, the best I could find was Perl based.</p>\n<p>Me being me, I decided to <a href=\"https://github.com/birkett/CloudFlare-DDNS-Updater\" target=\"_blank\">hack something together</a>.</p>\n<p>I should point out, my client is no where near production ready. It does awful things like ignoring MX records, and updating EVERY A RECORD.&nbsp;</p>\n<p>I will be continuing development of this, and accepting pull requests on GitHub.&nbsp;</p>\n<p>&nbsp;</p>\n<p>If you are going to use my client, please read the information in the README. And don\'t blame me if it nukes&nbsp;your DNS records :)</p>\n<p>&nbsp;</p>\n<p><a href=\"https://github.com/birkett/CloudFlare-DDNS-Updater\" target=\"_blank\"><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"https://c2.staticflickr.com/4/3869/14722671381_a3c5426a3e.jpg\" alt=\"CloudFlare DDNS Updater\" width=\"500\" height=\"472\" /></a></p>',0,1),(9,1407076005,'BM-800 Microphone Review','<p>Quick review and teardown of a &pound;20 microphone I picked up.&nbsp;</p>\n<p>Surprisingly good build quality for something so cheap.&nbsp;</p>\n<p><iframe class=\"youtube\" src=\"//www.youtube.com/embed/qXhfFtKHXEo\"></iframe></p>',0,1),(10,1411739861,'TFS 2013 non-default port gotcha','<p>Here\'s an annoying problem that I lost a few hours solving.&nbsp;</p>\n<p>&nbsp;</p>\n<p><span style=\"text-decoration: underline;\"><strong>Scenario:</strong></span></p>\n<p>You use Team Foundation Server locally (not visualstudio.com). You have moved the TFS site in IIS to a new vhost and added an additional port binding.&nbsp;</p>\n<p>You have used the TFS console and changed the Notification / Web access URL to reflect your changes in IIS.&nbsp;</p>\n<p>You can access the website fine on the new binding.&nbsp;</p>\n<p>But you <strong>cannot</strong> check out code / clone the repository (Git) - <strong>\"Authentication failed\".</strong></p>\n<p>&nbsp;</p>\n<p><span style=\"text-decoration: underline;\"><strong>Solution:</strong></span></p>\n<p>The issue is down to the accepted authentication methods for the vhost in IIS.&nbsp;</p>\n<p>Open the IIS Manager, browse to your TFS website in the Site tree.&nbsp;</p>\n<p>Open up the Authentication options.&nbsp;</p>\n<p>Enable only \"Windows Authentication\". Then click <strong>Advanced Settings</strong> on the right.&nbsp;</p>\n<p>Disabled \"Extended Protection\".</p>\n<p>On the right again, click <strong>Providers</strong>. Remove all providers, <strong>leaving only \"NTLM\" enabled.</strong>&nbsp;</p>\n<p>&nbsp;</p>\n<p>Job done. I use TFS with Git repositories. Prior to solving this, the web access worked fine, but cloning a repo with Git would give the error \"Authentication Failed\".&nbsp;</p>\n<p>These settings changes mimic the default vhost authentication settings, which are not necessarily the same as IIS\'s defaults when creating the site.&nbsp;</p>\n<p><a title=\"TFS Fix on Flickr\" href=\"https://www.flickr.com/photos/114119465@N04/15173078400/\" target=\"_blank\"><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"https://c4.staticflickr.com/4/3846/15173078400_b46fdf0a4e_c.jpg\" alt=\"TFS Fix on Flickr\" width=\"300\" height=\"188\" /></a></p>',0,1),(11,1419458499,'Merry Christmas','<p>To all my friends, family and readers - Merry Christmas and Happy New Year.&nbsp;</p>\n<p>&nbsp;</p>\n<p>It\'s been an eventful year for me, and I look forward to what 2015 holds.&nbsp;</p>\n<p>Maybe 2015 is the year of the Linux desktop???</p>',0,1);
/*!40000 ALTER TABLE `blog_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_pages`
--

DROP TABLE IF EXISTS `site_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site_pages` (
  `pageID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pageName` varchar(40) NOT NULL,
  `pageContent` text NOT NULL,
  `pageTitle` varchar(280) NOT NULL,
  PRIMARY KEY (`pageID`),
  UNIQUE KEY `pageID_UNIQUE` (`pageID`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_pages`
--

LOCK TABLES `site_pages` WRITE;
/*!40000 ALTER TABLE `site_pages` DISABLE KEYS */;
INSERT INTO `site_pages` VALUES (1,'about','<p>Born, did fairly well at school, 3 years at college and didn\'t go to uni. Grew a passion for technology and engineering somewhere in between.</p>\n<p>&nbsp;</p>\n<p>When not buried in something electronic or covered in engine oil, Anthony enjoys all things Mountain Bike related, Golf and has an obsession with Formula 1.&nbsp;</p>\n<p>&nbsp;</p>\n<p>After growing up around workshops, vehicle parts and tools, Oil entered his bloodstream. Anthony enjoys building, fabricating, taking apart, fixing and tweaking. Be it Cars, Furniture, Buildings or anything in between.&nbsp;</p>\n<p>&nbsp;</p>\n<p>From an early age, Anthony grew a keen interest in Computing. Over the years, this developed and included a much wider range of technology. As a hobby grew into a career, a number of brainchild projects entered planning.&nbsp;</p>\n<p>Anthony took a leap of faith in 2013, launching his own UK Limited Company. This&nbsp;company now oversees the projects.&nbsp;</p>\n<p>&nbsp;</p>\n<p>He also has no problem speaking of himself in the third person.&nbsp;</p>\n<p>&nbsp;</p>\n<p>&nbsp;</p>\n<p>I do, however, have trouble telling people what I am good and bad at. In business terms, I have a very weak SWOT analysis.&nbsp;So here is and attempt at one of those:</p>\n<p style=\"text-align: center;\">&nbsp;<img src=\"../img/swot.png\" alt=\"SWOT Analysis\" width=\"512\" height=\"512\" /></p>\n<p>&nbsp;</p>','About Anthony'),(2,'contact','<p>For general and business enquiries, please&nbsp;<a href=\"mailto:anthonyATa-birkett.co.uk\">Email me</a></p>\n<p>The above link is deliberately masked to prevent spam. Replace the AT symbol manually in your To: box.</p>\n<p>&nbsp;</p>\n<p>For questions and comments that you don\'t mind being public -&nbsp;<a href=\"https://twitter.com/intent/tweet?screen_name=birkett26\" target=\"_blank\">Tweet me!</a></p>\n<p>I am active on&nbsp;<a href=\"http://www.steamcommunity.com/id/birkett\" target=\"_blank\">Steam</a>&nbsp;and various forums around the internet.&nbsp;</p>','Contacting Anthony'),(3,'photos','<p>From time to time, I may upload photographs of projects, or things of interest to me. Here are some randomly selected snaps. For the whole collection, be sure to <a href=\"http://www.flickr.com/users/birkett26\" target=\"_blank\">check my flickr account.</a></p>\n<!-- Start of Flickr Badge -->\n<script src=\"http://www.flickr.com/badge_code_v2.gne?count=10&amp;display=random&amp;size=m&amp;layout=x&amp;source=user&amp;user=114119465%40N04\"></script>\n<!-- End of Flickr Badge -->\n<p>&nbsp;</p>','Photos'),(4,'videos','<p>The thoughts, ramblings and activities of life. For all videos, take a look at <a href=\"http://www.youtube.com/birkett26\" target=\"_blank\">my YouTube channel.</a></p>\n<p>&nbsp;</p>\n<p style=\"text-align: center;\"><iframe class=\"youtube\" src=\"//www.youtube.com/embed/videoseries?list=PLN-BZXUNsLJDklBYrRAgO_lBAM5QFbokB\"></iframe></p>','Videos'),(5,'projects','<p style=\"text-align: left;\">This is a list of projects I am currently working on in some capacity. Some are single man efforts, others I am working as part of a team.&nbsp;</p>\n<p style=\"text-align: left;\">&nbsp;</p>\n<p style=\"text-align: center;\"><a title=\"IT Lincs Ltd\" href=\"http://www.it-lincs.co.uk\" target=\"_blank\">IT Lincs Ltd</a>&nbsp;</p>\n<p style=\"text-align: center;\">My Project Company and front for personal business activities</p>\n<p style=\"text-align: center;\">&nbsp;</p>\n<p style=\"text-align: center;\"><a title=\"Tantalum Customs\" href=\"http://www.tantalumcustoms.co.uk\" target=\"_blank\">Tantalum Customs</a>&nbsp;</p>\n<p style=\"text-align: center;\">Custom built PC\'s and hardware modding</p>\n<p style=\"text-align: center;\">&nbsp;</p>\n<p style=\"text-align: center;\"><a title=\"The Live Home\" href=\"http://www.thelivehome.co.uk\" target=\"_blank\">The Live Home</a>&nbsp;</p>\n<p style=\"text-align: center;\">Internet connected devices and systems for a standardised Smart Home infrastructure</p>\n<p style=\"text-align: center;\">&nbsp;</p>\n<p style=\"text-align: center;\"><a title=\"birk.it\" href=\"http://birk.it\" target=\"_blank\">birk.it URL shortner</a></p>\n<p style=\"text-align: center;\">Simple web service and directory for short URL\'s</p>\n<p style=\"text-align: center;\">&nbsp;</p>\n<p style=\"text-align: center;\"><a title=\"Mani Admin Plugin\" href=\"https://code.google.com/p/maniadminplugin/\" target=\"_blank\">Mani Admin Plugin</a>&nbsp;</p>\n<p style=\"text-align: center;\">Source Engine game server administration plugin</p>','Projects'),(6,'404','<p>The requested page was not found, so <a href=\"../\">how about my amazing homepage instead?</a></p>','That was a code 404...');
/*!40000 ALTER TABLE `site_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_tweets`
--

DROP TABLE IF EXISTS `site_tweets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site_tweets` (
  `tweetID` varchar(100) NOT NULL,
  `tweetTimestamp` int(10) NOT NULL,
  `tweetText` varchar(560) NOT NULL,
  `tweetAvatar` varchar(1000) NOT NULL,
  `tweetName` varchar(100) NOT NULL,
  `tweetScreenname` varchar(60) NOT NULL,
  `tweetFetchtime` int(10) NOT NULL,
  PRIMARY KEY (`tweetID`),
  UNIQUE KEY `tweetID_UNIQUE` (`tweetID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_tweets`
--

LOCK TABLES `site_tweets` WRITE;
/*!40000 ALTER TABLE `site_tweets` DISABLE KEYS */;
/*!40000 ALTER TABLE `site_tweets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_users`
--

DROP TABLE IF EXISTS `site_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site_users` (
  `username` varchar(45) NOT NULL,
  `password` varchar(1024) NOT NULL,
  PRIMARY KEY (`username`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_users`
--

LOCK TABLES `site_users` WRITE;
/*!40000 ALTER TABLE `site_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `site_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-28 16:25:20
