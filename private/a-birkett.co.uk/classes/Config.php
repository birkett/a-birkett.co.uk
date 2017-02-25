<?php
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
 * PHP Version 5.3
 *
 * @category  Config
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\classes;

/**
 * Defines a set of symbols, building a site configuration.
 *
 * As well as defining symbols, the site config is used to set PHP.ini options,
 * such as error_reporting, display_errors and date_default_timezone_set.
 *
 * The end goal for this file is to allow the site to move servers, and be back
 * up and running after making basic changes here. The essential part of this
 * is the database connection detail, which if set correctly, the site should be
 * opperational.
 *
 * @category  Config
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */
class Config
{


    /**
     * Set up the environment
     * @return void
     */
    public function __construct()
    {
        // Show PHP errors and warnings.
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        // Timezone for converting timestamps.
        date_default_timezone_set('Europe/London');

        // Set up UTF-8 encoding as the default.
        ini_set('default_charset', 'utf-8');

        // Time to make sessions expire after (in seconds).
        define('SESSION_EXPIRY_TIME', 3600);

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

        // Define a symbol when requesting an admin page.
        $file = filter_input(INPUT_SERVER, 'PHP_SELF', FILTER_SANITIZE_STRING);

        // Annoying bug where INPUT_SERVER is stripped on some hosts.
        if ($file === null) {
            $file = $_SERVER['PHP_SELF'];
        }

        // Admin pages.
        if (mb_strpos($file, ADMIN_FOLDER) !== false) {
            define('ADMINPAGE', 1);
        }

        // Disable unsafe things when running from the CLI (for tests).
        if (php_sapi_name() === 'cli') {
            define('RUNNING_PHPUNIT_TESTS', true);
        }

    }//end __construct()
}//end class
