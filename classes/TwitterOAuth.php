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
 * @category  Classes
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\classes;

/**
 * The first PHP Library to support OAuth for Twitter's REST API
 *
 * Originally written by Abraham Williams, extensivly modified.
 *
 * @category  Classes
 * @package   PersonalWebsite
 * @author    Abraham Williams <abraham@abrah.am>
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://abrah.am
 */
class TwitterOAuth
{


    /**
     * Construct TwitterOAuth object
     * @return none
     */
    public function __construct()
    {
        $this->consumerKey      = TWITTER_CONSUMER_KEY;
        $this->consumerSecret   = TWITTER_CONSUMER_SECRET;
        $this->oauthToken       = TWITTER_OAUTH_TOKEN;
        $this->oauthTokenSecret = TWITTER_OAUTH_SECRET;

    }//end __construct()


    /**
     * Format and sign an OAuth / API request
     * @param  string $url        Request string.
     * @param  string $method     Request method.
     * @param  array  $parameters Extra parameters array.
     * @return array Response
     */
    public function oAuthRequest($url, $method, array $parameters)
    {
        $url = 'https://api.twitter.com/1.1/'.$url.'.json';

        $request = new OAuthRequest(
            $this->consumerKey,
            $this->oauthToken,
            $url,
            $parameters
        );
        $request->signRequest(
            $url,
            $method,
            $this->consumerSecret,
            $this->oauthTokenSecret
        );

        if ($method === 'GET') {
            $response = $this->http($request->toUrl($url), 'GET', array());
        }

        if ($method === 'POST') {
            $response = $this->http($url, $method, $request->toPostdata());
        }

        $obj = json_decode($response);

        return $obj;

    }//end oAuthRequest()


    /**
     * Make an HTTP request
     * @param  string $url        Request string.
     * @param  string $method     Request method.
     * @param  array  $postfields Extra parameters array.
     * @return array API results
     */
    private function http($url, $method, array $postfields)
    {
        $curl = curl_init();
        // Curl settings.
        curl_setopt($curl, CURLOPT_USERAGENT, 'twitterAPI/PHP');
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:'));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HEADER, false);

        if ($method === 'POST') {
            curl_setopt($curl, CURLOPT_POST, true);
            if (empty($postfields) === false) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $postfields);
            }
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;

    }//end http()
}//end class
