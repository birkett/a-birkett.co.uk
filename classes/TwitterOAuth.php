<?php
/**
 * The first PHP Library to support OAuth for Twitter's REST API
 *
 * PHP Version 5.5
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
     * Contains the last HTTP status code returned
     * @var int $httpCode
     */
    public $httpCode;

    /**
     * Contains the last API call
     * @var string $url
     */
    public $url;

    /**
     * Set up the API root URL
     * @var string $host
     */
    public $host = 'https://api.twitter.com/1.1/';

    /**
     * Set timeout default
     * @var int $timeout
     */
    public $timeout = 30;

    /**
     * Contains the last HTTP headers returned
     * @var mixed[] $httpInfo
     */
    public $httpInfo;

    /**
     * Set the useragnet
     * @var string $userAgent
     */
    public $useragent = 'TwitterOAuth v0.2.0-beta2';


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
     * GET wrapper for oAuthRequest.
     * @param  string $url        Request string.
     * @param  array  $parameters Additional parameters.
     * @return array Response array
     */
    public function get($url, $parameters = array())
    {
        $response = $this->oAuthRequest($url, 'GET', $parameters);
        return json_decode($response);

    }//end get()


    /**
     * POST wrapper for oAuthRequest.
     * @param  string $url        Request string.
     * @param  array  $parameters Additional parameters.
     * @return array Response array
     */
    public function post($url, $parameters = array())
    {
        $response = $this->oAuthRequest($url, 'POST', $parameters);
        return json_decode($response);

    }//end post()


    /**
     * Format and sign an OAuth / API request
     * @param  string $url        Request string.
     * @param  string $method     Request method.
     * @param  array  $parameters Extra parameters array.
     * @return array Response
     */
    private function oAuthRequest($url, $method, $parameters)
    {
        $test = 'json';
        if (strrpos($url, 'https://') !== 0 && strrpos($url, 'http://') !== 0) {
            $url = "{$this->host}{$url}.{$test}";
        }

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
                return $this->http($request->toUrl(), 'GET');
            default:
                return $this->http(
                    $request->getNormalizedHttpUrl(),
                    $method,
                    $request->toPostdata()
                );
        }

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
        $this->httpInfo = array();
        $ci = curl_init();
        // Curl settings.
        curl_setopt($ci, CURLOPT_USERAGENT, $this->useragent);
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($ci, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ci, CURLOPT_HTTPHEADER, array('Expect:'));
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ci, CURLOPT_HEADERFUNCTION, array($this, 'getHeader'));
        curl_setopt($ci, CURLOPT_HEADER, false);

        switch ($method) {
            case 'POST':
                curl_setopt($ci, CURLOPT_POST, true);
                if (empty($postfields) === false) {
                    curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
                }
                break;
        }

        curl_setopt($ci, CURLOPT_URL, $url);
        $response       = curl_exec($ci);
        $this->httpCode = curl_getinfo($ci, CURLINFO_HTTP_CODE);
        $this->httpInfo = array_merge($this->httpInfo, curl_getinfo($ci));
        $this->url      = $url;
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
            $value = trim(substr($header, $i + 2));
            $this->httpHeader[$key] = $value;
        }

        return strlen($header);

    }//end getHeader()
}//end class
