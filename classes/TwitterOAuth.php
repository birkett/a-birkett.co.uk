<?php
/**
* The first PHP Library to support OAuth for Twitter's REST API
*
* PHP Version 5.5
*
* @category Classes
* @package  PersonalWebsite
* @author   Abraham Williams <abraham@abrah.am>
* @author   Anthony Birkett <anthony@a-birkett.co.uk>
* @license  http://opensource.org/licenses/MIT MIT
* @link     http://abrah.am
*/
namespace ABirkett\classes;

class TwitterOAuth
{
    /**
    * Contains the last HTTP status code returned
    * @var int $http_code
    */
    public $http_code;

    /**
    * Contains the last API call
    * @var string $url
    */
    public $url;

    /**
    * Set up the API root URL
    * @var string $host
    */
    public $host = "https://api.twitter.com/1.1/";

    /**
    * Set timeout default
    * @var int $timeout
    */
    public $timeout = 30;

    /**
    * Contains the last HTTP headers returned
    * @var mixed[] $http_info
    */
    public $http_info;

    /**
    * Set the useragnet
    * @var string $userAgent
    */
    public $useragent = 'TwitterOAuth v0.2.0-beta2';

    /**
    * Construct TwitterOAuth object
    * @param string $c_key    API consumer key
    * @param string $c_secret API consumer secret
    * @param string $o_token  API OAuth token
    * @param string $o_secret API OAuth token secret
    * @return none
    */
    public function __construct($c_key, $c_secret, $o_token, $o_secret)
    {
        $this->consumer_key = $c_key;
        $this->consumer_secret = $c_secret;
        $this->oauth_token = $o_token;
        $this->oauth_token_secret = $o_secret;
    }

    /**
    * GET wrapper for oAuthRequest.
    * @param string  $url        Request string
    * @param mixed[] $parameters Additional parameters
    * @return mixed[] Response array
    */
    public function get($url, $parameters = array())
    {
        $response = $this->oAuthRequest($url, 'GET', $parameters);
        return json_decode($response);
    }

    /**
    * POST wrapper for oAuthRequest.
    * @param string  $url        Request string
    * @param mixed[] $parameters Additional parameters
    * @return mixed[] Response array
    */
    public function post($url, $parameters = array())
    {
        $response = $this->oAuthRequest($url, 'POST', $parameters);
        return json_decode($response);
    }

    /**
    * Format and sign an OAuth / API request
    * @param string  $url        Request string
    * @param string  $method     Request method
    * @param mixed[] $parameters Extra parameters array
    * @return mixedp[] Response
    */
    private function oAuthRequest($url, $method, $parameters)
    {
        $test = 'json';
        if (strrpos($url, 'https://') !== 0 && strrpos($url, 'http://') !== 0) {
            $url = "{$this->host}{$url}.{$test}";
        }
        $request = OAuthRequest::fromConsumerAndToken(
            $this->consumer_key,
            $this->oauth_token,
            $method,
            $url,
            $parameters
        );
        $request->signRequest(
            $this->consumer_key,
            $this->consumer_secret,
            $this->oauth_token,
            $this->oauth_token_secret
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
    }

    /**
    * Make an HTTP request
    * @param string  $url        Request string
    * @param string  $method     Request method
    * @param mixed[] $postfields Extra parameters array
    * @return mixedp[ API results
    */
    private function http($url, $method, $postfields = null)
    {
        $this->http_info = array();
        $ci = curl_init();
        /* Curl settings */
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
                if (!empty($postfields)) {
                    curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
                }
                break;
        }

        curl_setopt($ci, CURLOPT_URL, $url);
        $response = curl_exec($ci);
        $this->http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
        $this->http_info = array_merge($this->http_info, curl_getinfo($ci));
        $this->url = $url;
        curl_close($ci);
        return $response;
    }

    /**
    * Get the header info to store
    * @param mixed[] $ch     Unknown
    * @param string  $header Input header
    * @return int Header length
    */
    private function getHeader($ch, $header)
    {
        $i = strpos($header, ':');
        if (!empty($i)) {
            $key = str_replace('-', '_', strtolower(substr($header, 0, $i)));
            $value = trim(substr($header, $i + 2));
            $this->http_header[$key] = $value;
        }
        return strlen($header);
    }
}
