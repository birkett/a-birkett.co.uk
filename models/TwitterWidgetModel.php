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
 * @category  Models
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\models;

/**
 * Handles data for the TwitterWidget. Glue between the database and controller.
 *
 * The method getTweetsFromDatabase() is the only one called by the controller,
 * but this will call the other functions to update the locally cached tweets
 * when needed. (Every 15 mins by default).
 *
 * This makes use of the Twitter API to GET statuses/user_timeline.
 *
 * @category  Models
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */
class TwitterWidgetModel extends BasePageModel
{


    /**
     * Get latest tweets via Twitter API
     * @return array Array of tweets data
     */
    private function getLatestTweets()
    {
        $params  = array(
                    'screen_name' => TWEETS_WIDGET_USER,
                    'count'       => TWEETS_WIDGET_MAX,
                    'include_rts' => true,
                   );
        $twitter = new \ABirkett\classes\TwitterOAuth();

        return $twitter->oAuthRequest('statuses/user_timeline', 'GET', $params);

    }//end getLatestTweets()


    /**
     * Cache the latest tweets in the local DB to reduce Twitter API requests.
     * @return void
     */
    private function updateTweetsDatabase()
    {
        $tweets = $this->getLatestTweets();

        if (isset($tweets->errors) === true) {
            echo 'Twitter error: '.$tweets->errors[0]->message;

            return;
        }

        if (empty($tweets) === true) {
            echo 'Could not connect to Twitter';

            return;
        }

        // WARNING.
        $this->database->runQuery('DELETE FROM site_tweets', array());

        $exectime = time();

        foreach ($tweets as $tweet) {
            $tweetText = $tweet->text;
            // Make links active.
            $tweetText = preg_replace(
                '@(https?://([-\w\.]+)+(/([\w/_\.]*(\?\S+)?(#\S+)?)?)?)@',
                '<a target="_blank" href="$1">$1</a>',
                $tweetText
            );
            // Linkify user mentions.
            $tweetText = preg_replace(
                '/@(\w+)/',
                '<a target="_blank" href="http://twitter.com/$1">@$1</a>',
                $tweetText
            );
            // Linkify tags.
            $tweetText = preg_replace(
                '/\s+#(\w+)/',
                ' <a target="_blank" href="http://twitter.com/search?q=#$1">'.
                '#$1</a>',
                $tweetText
            );

            $timestamp  = strtotime($tweet->created_at);
            $name       = $tweet->user->name;
            $screenname = $tweet->user->screen_name;
            $avatar     = $tweet->user->profile_image_url_https;

            if (isset($tweet->retweeted_status) === true) {
                $timestamp  = strtotime($tweet->retweeted_status->created_at);
                $name       = $tweet->retweeted_status->user->name;
                $screenname = $tweet->retweeted_status->user->screen_name;
                $avatar     = $tweet->retweeted_status->user
                    ->profile_image_url_https;
            }

            $this->database->runQuery(
                'INSERT INTO site_tweets (tweetID, tweetTimestamp,'.
                ' tweetText, tweetAvatar, tweetName, tweetScreenname,'.
                ' tweetUpdatetime) VALUES ( :id, :timestamp, :text, :image,'.
                ' :name, :screenname, :updatetime )',
                array(
                 ':id'         => $tweet->id_str,
                 ':timestamp'  => $timestamp,
                 ':text'       => $tweetText,
                 ':image'      => $avatar,
                 ':name'       => $name,
                 ':screenname' => $screenname,
                 ':updatetime' => $exectime,
                )
            );
        }//end foreach

    }//end updateTweetsDatabase()


    /**
     * Get the latest tweets from the local database
     * @return array Tweets data array
     */
    public function getTweetsFromDatabase()
    {
        // Get the last twitter update time.
        $results = $this->database->runQuery(
            'SELECT tweetUpdatetime FROM site_tweets LIMIT 1',
            array()
        );

        $lastfetchtime = $this->database->getRow($results);

        // Update the tweets if not done in the last 15 mins.
        if ($lastfetchtime->tweetUpdatetime < (time() - 900)) {
            $this->updateTweetsDatabase();
        }

        // Get the tweets.
        return $this->database->runQuery(
            'SELECT * FROM site_tweets ORDER BY tweetTimestamp ASC LIMIT '.
            TWEETS_WIDGET_MAX,
            array()
        );

    }//end getTweetsFromDatabase()


    /**
     * Get the time elapsed since a unix timestamp i.e. "3 hours"
     * @param integer $timestamp Unix timestamp.
     * @return string Time elapsed
     */
    public function timeElapsed($timestamp)
    {
        $periods = array(
                    'second',
                    'minute',
                    'hour',
                    'day',
                    'week',
                    'month',
                    'year',
                    'decade',
                   );

        $lengths = array(
                    '60',
                    '60',
                    '24',
                    '7',
                    '4.35',
                    '12',
                    '10',
                   );

        $now = time();

        $diff  = ($now - $timestamp);
        $tense = ' ago';

        // Just incase the clock is wrong and timestamps are in the future.
        if ($now < $timestamp) {
            $diff  = ($timestamp - $now);
            $tense = ' from now';
        }

        $lengthsCount = count($lengths);
        for ($j = 0; $diff >= $lengths[$j] && $j < ($lengthsCount - 1); $j++) {
            $diff /= $lengths[$j];
        }

        $diff = round($diff);

        // Test the float value to 5 digit precision.
        if (abs($diff - 1) > 0.0001) {
            $periods[$j] .= 's';
        }

        return $diff.' '.$periods[$j].$tense;

    }//end timeElapsed()
}//end class
