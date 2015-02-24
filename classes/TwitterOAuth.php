<?php
/**
 * The first PHP Library to support OAuth for Twitter's REST API
 *
 * PHP Version 5.3
 *
 * @category  Classes
 * @package   PersonalWebsite
 * @author    Abraham Williams <abraham@abrah.am>
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      http://abrah.am
 */

namespace ABirkett\classes;

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
    public function oAuthRequest($url, $method, $parameters)
    {
        $url = 'https://api.twitter.com/1.1/'.$url.'.json';

        $request = new OAuthRequest(
            $this->consumerKey,
            $this->oauthToken,
            $method,
            $url,
            $parameters
        );
        $request->signRequest(
            $this->consumerSecret,
            $this->oauthTokenSecret
        );
        switch ($method) {
            case 'GET':
                $response = $this->http($request->toUrl(), 'GET');
                break;

            default:
                $response = $this->http(
                    $request->getNormalizedHttpUrl(),
                    $method,
                    $request->toPostdata()
                );
                break;
        }

        return json_decode($response);

    }//end oAuthRequest()


    /**
     * Make an HTTP request
     * @param  string $url        Request string.
     * @param  string $method     Request method.
     * @param  array  $postfields Extra parameters array.
     * @return array API results
     */
    private function http($url, $method, $postfields = null)
    {
        $ci = curl_init();
        // Curl settings.
        curl_setopt($ci, CURLOPT_USERAGENT, 'twitterAPI/PHP');
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ci, CURLOPT_HTTPHEADER, array('Expect:'));
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ci, CURLOPT_HEADERFUNCTION, array($this, 'getHeader'));
        curl_setopt($ci, CURLOPT_HEADER, false);

        if ($method === 'POST') {
            curl_setopt($ci, CURLOPT_POST, true);
            if (empty($postfields) === false) {
                curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
            }
        }

        curl_setopt($ci, CURLOPT_URL, $url);
        $response       = curl_exec($ci);
        curl_close($ci);
        return $response;

    }//end http()


    /**
     * Get the header info to store
     * @param array  $ch     Unknown.
     * @param string $header Input header.
     * @return int Header length
     */
    private function getHeader($ch, $header)
    {
        $i = strpos($header, ':');
        if (empty($i) === false) {
            $key   = str_replace('-', '_', strtolower(substr($header, 0, $i)));
            $value = trim(substr($header, ($i + 2)));
            $this->httpHeader[$key] = $value;
        }

        return strlen($header);

    }//end getHeader()
}//end class
