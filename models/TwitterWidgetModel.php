<?php
/**
 * TwitterWidgetModel - glue between the database and TwitterWidgetController
 *
 * PHP Version 5.4
 *
 * @category  Models
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\models;

class TwitterWidgetModel extends BasePageModel
{


    /**
     * Get latest tweets via Twitter API
     * @return array Array of tweets data
     */
    private function getLatestTweets()
    {
        $params = array(
            'screen_name' => TWEETS_WIDGET_USER,
            'count'       => TWEETS_WIDGET_MAX,
            'include_rts' => true
        );
        $twitter = new \ABirkett\classes\TwitterOAuth();
        return $twitter->get('statuses/user_timeline', $params);

    }//end getLatestTweets()


    /**
     * Cache the latest tweets in the local DB to reduce Twitter API requests.
     * @return void
     */
    private function updateTweetsDatabase()
    {
        $tweets = $this->getLatestTweets();
        // WARNING.
        $this->database->runQuery('DELETE FROM site_tweets');

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

            if (isset($tweet->retweeted_status) === true) {
                $timestamp = strtotime($tweet->retweeted_status->created_at);
                $name = $tweet->retweeted_status->user->name;
                $screenname = $tweet->retweeted_status->user->screen_name;
                $avatar = $tweet->retweeted_status->user->profile_image_url_https;
            } else {
                $timestamp = strtotime($tweet->created_at);
                $name = $tweet->user->name;
                $screenname = $tweet->user->screen_name;
                $avatar = $tweet->user->profile_image_url_https;
            }

            $this->database->runQuery(
                'INSERT INTO site_tweets (tweet_id, tweet_timestamp,'.
                ' tweet_text, tweet_avatar, tweet_name, tweet_screenname,'.
                ' tweet_updatetime) VALUES ( :id, :timestamp, :text, :image,'.
                ' :name, :screenname, :updatetime )',
                array(
                    ':id' => $tweet->id_str,
                    ':timestamp' => $timestamp,
                    ':text' => $tweetText,
                    ':image' => $avatar,
                    ':name' => $name,
                    ':screenname' => $screenname,
                    ':updatetime' => $exectime,
                )
            );
        }

    }//end updateTweetsDatabase()


    /**
     * Get the latest tweets from the local database
     * @return array Tweets data array
     */
    public function getTweetsFromDatabase()
    {
        // Get the last twitter update time.
        $lastfetchtime = $this->database->runQuery(
            'SELECT tweet_updatetime FROM site_tweets LIMIT 1'
        );
        $lastfetchtime = $lastfetchtime[0]['tweet_updatetime'];

        // Update the tweets if not done in the last 15 mins.
        if ($lastfetchtime < (time() - 900)) {
            $this->updateTweetsDatabase();
        }

        // Get the tweets.
        return $this->database->runQuery(
            'SELECT * FROM site_tweets ORDER BY tweet_timestamp ASC LIMIT '.
            TWEETS_WIDGET_MAX
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

        if ($now > $timestamp) {
            $diff  = $now - $timestamp;
            $tense = 'ago';
        } else {
            $diff  = $timestamp - $now;
            $tense = 'from now';
        }

        for ($j = 0; $diff >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
            $diff /= $lengths[$j];
        }

        $diff = round($diff);

        if ($diff !== 1) {
            $periods[$j].= 's';
        }

        return "$diff $periods[$j] {$tense}";

    }//end timeElapsed()
}//end class
