<?php
/**
 * TwitterWidgetController - pull data from the model to populate the template
 *
 * PHP Version 5.4
 *
 * @category  Controllers
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      http://www.a-birkett.co.uk
 */
namespace ABirkett\controllers;

class TwitterWidgetController extends BasePageController
{


    /**
     * Build the Twitter widget
     * @param string $output Unparsed template passed by reference.
     * @return none
     */
    public function __construct(&$output)
    {
        parent::__construct($output);
        $this->model = new \ABirkett\models\TwitterWidgetModel();
        $tweets      = $this->model->getTweetsFromDatabase();
        $tweetloop   = $this->templateEngine->LogicTag(
            '{TWEETLOOP}',
            '{/TWEETLOOP}',
            $output
        );

        foreach ($tweets as $tweet) {
            $temp = $tweetloop;
            $tags = array(
                    '{TWEETID}' => $tweet['tweet_id'],
                    '{TWEETSCREENNAME}' => $tweet['tweet_screenname'],
                    '{TWEETNAME}' => $tweet['tweet_name'],
                    '{TWEETAVATAR}' => $tweet['tweet_avatar'],
                    '{TWEETTEXT}' => $tweet['tweet_text'],
                    '{TWEETTIMESTAMP}' =>
                        $this->model->timeElapsed($tweet['tweet_timestamp']),
            );

            $this->templateEngine->parseTags($tags, $temp);

            $tags = array(
                '{TWEETLOOP}',
                '{/TWEETLOOP}',
            );
            $this->templateEngine->removeTags($tags, $temp);

            $temp = '{/TWEETLOOP}' . $temp;

            $this->templateEngine->replaceTag('{/TWEETLOOP}', $temp, $output);
        }//end foreach

        $this->templateEngine->removeLogicTag(
            '{TWEETLOOP}',
            '{/TWEETLOOP}',
            $output
        );

    }//end __construct()
}//end class
