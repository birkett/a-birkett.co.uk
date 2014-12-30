<?php
//-----------------------------------------------------------------------------
// Site configuration
//-----------------------------------------------------------------------------

//Show PHP errors and warnings
error_reporting(E_ALL);
ini_set("display_errors", 1);

//Timezone for converting timestamps
date_default_timezone_set("Europe/London");

//Default display format for timestamps
define('DATE_FORMAT', 'l dS F Y');

//Allows admin folder to be renamed
define('ADMIN_FOLDER', 'admin/');

//Allows template folder to be renamed
define('TEMPLATE_FOLDER', 'template/');

//Base title for web pages
define('SITE_TITLE', 'Anthony Birkett');

//Enables the Christmas decorations
define('CHRISTMAS', 0);

//Number of posts per page for the blog pagniation
define('BLOG_POSTS_PER_PAGE', 5);

//ReCaptcha comment verification keys
define('RECAPTCHA_PUBLIC_KEY', 'pub-key');
define('RECAPTHCA_PRIVATE_KEY', 'priv-key');

//Twitter keys used when tweeting new blog posts
define("TWITTER_CONSUMER_KEY", 'cons-key');
define("TWITTER_CONSUMER_SECRET", 'cons-secret');
define("TWITTER_OAUTH_TOKEN", 'oauth-key');
define("TWITTER_OAUTH_SECRET", 'oauth-secret');

//Database connection
define('DATABASE_HOSTNAME', 'localhost');
define('DATABASE_USERNAME', 'root');
define('DATABASE_PASSWORD', 'newpass');
define('DATABASE_PORT', 3306);
define('DATABASE_NAME', 'database');
?>
