<?php
//-----------------------------------------------------------------------------
// Site configuration
//-----------------------------------------------------------------------------

//Show PHP errors and warnings
error_reporting(E_ALL);
ini_set("display_errors", 1);

//Timezone for converting timestamps
date_default_timezone_set("Europe/London");

//Used for the base of URLs to ensure rewriting doesn't mess up relative links
define('BASE_URL', 'http://localhost/');

//Allows admin folder to be renamed
define('ADMIN_FOLDER', 'admin/');

//Base title for web pages
define('SITE_TITLE', 'Anthony Birkett');

//Enables the Christmas decorations
define('CHRISTMAS', 0);

//Number of posts per page for the blog pagniation
define('BLOG_POSTS_PER_PAGE', 5);

//Default display format for timestamps
define('DATE_FORMAT', 'l dS F Y');

//ReCaptcha comment verification keys
define('RECAPTCHA_PUBLIC_KEY', 'pub-key');
define('RECAPTHCA_PRIVATE_KEY', 'priv-key');

//Database connection
define('DATABASE_HOSTNAME', 'host');
define('DATABASE_USERNAME', 'user');
define('DATABASE_PASSWORD', 'password');
define('DATABASE_PORT', 3306);
define('DATABASE_NAME', 'database');
?>
