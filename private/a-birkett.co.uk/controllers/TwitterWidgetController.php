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
 * @category  Controllers
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\controllers;

use ABirkett\controllers\BasePageController;
use ABirkett\models\TwitterWidgetModel;

/**
 * Handles generating the Twitter widget.
 *
 * The call to model::getTweetsFromDatabase() will automatically call the
 * Twitter API if the locally cached data is old (by default, 15 minutes).
 *
 * @category  Controllers
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */
class TwitterWidgetController extends BasePageController
{


    /**
     * Build the Twitter widget.
     * @return none
     */
    public function __construct()
    {
        parent::__construct();
        $this->model = new TwitterWidgetModel();

        $this->defineAction('GET', 'default', 'twGetHandler', array());
    }//end __construct()


    /**
     * Build the Twitter widget
     *
     * @return none
     */
    public function twGetHandler()
    {
        $tweets    = $this->model->getTweetsFromDatabase();
        $tweetloop = $this->templateEngine->LogicTag(
            '{TWEETLOOP}',
            '{/TWEETLOOP}',
            $this->unparsedTemplate
        );

        // Bail if the database is down.
        if (empty($tweets) === true) {
            $tweets = array();
        }

        foreach ($tweets as $tweet) {
            $temp = $tweetloop;
            $time = $tweet->tweetTimestamp;
            $tags = array(
                     '{TWEETID}'         => $tweet->tweetID,
                     '{TWEETSCREENNAME}' => $tweet->tweetScreenname,
                     '{TWEETNAME}'       => $tweet->tweetName,
                     '{TWEETAVATAR}'     => $tweet->tweetAvatar,
                     '{TWEETTEXT}'       => $tweet->tweetText,
                     '{TWEETTIMESTAMP}'  => $this->model->timeElapsed($time),
                    );

            $this->templateEngine->parseTags($tags, $temp);

            $tags = array(
                     '{TWEETLOOP}',
                     '{/TWEETLOOP}',
                    );
            $this->templateEngine->removeTags($tags, $temp);

            $temp = '{/TWEETLOOP}'.$temp;

            $this->templateEngine->replaceTag('{/TWEETLOOP}', $temp, $this->unparsedTemplate);
        }//end foreach

        $this->templateEngine->replaceTag(
            '{TWITTERUSER}',
            TWEETS_WIDGET_USER,
            $this->unparsedTemplate
        );

        $this->templateEngine->removeLogicTag(
            '{TWEETLOOP}',
            '{/TWEETLOOP}',
            $this->unparsedTemplate
        );

    }//end getHandler()
}//end class
