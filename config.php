<?php
/**
 * Site configuration options
 *
 * PHP Version 5.3
 *
 * @category  Config
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett;

class Config
{


    /**
     * Set up the environment
     * @return void
     */
    public static function init()
    {
        // Show PHP errors and warnings.
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        // Timezone for converting timestamps.
        date_default_timezone_set('Europe/London');

        // Default display format for timestamps.
        define('DATE_FORMAT', 'l dS F Y');

        // Allows admin folder to be renamed.
        define('ADMIN_FOLDER', 'admin/');

        // Allows template folder to be renamed.
        define('TEMPLATE_FOLDER', 'template/');

        // Base title for web pages.
        define('SITE_TITLE', 'Anthony Birkett');

        // Enables the Christmas decorations.
        define('CHRISTMAS', 0);

        // Number of posts per page for the blog pagniation.
        define('BLOG_POSTS_PER_PAGE', 5);

        // Number of tweets to fetch and cache from Twitter.
        define('TWEETS_WIDGET_MAX', 5);

        // The user to fetch Tweets from.
        define('TWEETS_WIDGET_USER', 'birkett26');

        // Cost value when hashing passwords.
        define('HASHING_COST', 10);

        // ReCaptcha comment verification keys.
        define(
            'RECAPTCHA_PUBLIC_KEY',
            'pub-key'
        );
        define(
            'RECAPTHCA_PRIVATE_KEY',
            'priv-key'
        );

        // Twitter keys used when tweeting new blog posts.
        define(
            'TWITTER_CONSUMER_KEY',
            'cons-key'
        );
        define(
            'TWITTER_CONSUMER_SECRET',
            'cons-secret'
        );
        define(
            'TWITTER_OAUTH_TOKEN',
            'oauth-key'
        );
        define(
            'TWITTER_OAUTH_SECRET',
            'oauth-secret'
        );

        // Database connection.
        define('DATABASE_HOSTNAME', 'host');
        define('DATABASE_USERNAME', 'user');
        define('DATABASE_PASSWORD', 'password');
        define('DATABASE_PORT', 3306);
        define('DATABASE_NAME', 'database');

        // Define a symbol when requesting an admin page
        $file = filter_input(INPUT_SERVER, 'PHP_SELF', FILTER_SANITIZE_STRING);
        if (strpos($file, ADMIN_FOLDER) !== false) {
            define('ADMINPAGE', 1);
        }

    }//end init()
}//end class
