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
 * @copyright 2014 Andy Smith
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\classes;

/**
 * OAuth request generation.
 *
 * This generated OAuth requests, including the authorisation header.
 *
 * @category  Classes
 * @package   PersonalWebsite
 * @author    Andy Smith <unknown@unknown.com>
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2014 Andy Smith
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://term.ie
 */
class OAuthRequest
{

    /**
     * Request parameters array
     * @var array $parameters
     */
    private $parameters;


    /**
     * Create an OAuth request
     * @param  string $cKey    Consumer key.
     * @param  string $oToken  OAuth token.
     * @param  string $httpUrl Request URL.
     * @param  array  $params  Additional parameters as array.
     * @return object OAuthRequest instance
     */
    public function __construct($cKey, $oToken, $httpUrl, array $params)
    {
        if (isset($params) === false) {
            $params = array();
        }

        $defaults = array(
                     'oauth_version'      => '1.0',
                     'oauth_nonce'        => md5(microtime().mt_rand()),
                     'oauth_timestamp'    => time(),
                     'oauth_consumer_key' => $cKey,
                     'oauth_token'        => $oToken,
                    );

        $params = array_merge($defaults, $params);
        $params = array_merge(
            $this->parseParameters(parse_url($httpUrl, PHP_URL_QUERY)),
            $params
        );

        $this->parameters = $params;

    }//end __construct()


    /**
     * Builds a URL usable for a GET request
     * @param string $url HTTP URL.
     * @return string URL
     */
    public function toUrl($url)
    {
        $postData = $this->toPostdata();
        $out      = $url;
        if (isset($postData) === true) {
            $out .= '?'.$postData;
        }

        return $out;

    }//end toUrl()


    /**
     * Builds the data one would send in a POST request
     * @return string Data
     */
    public function toPostdata()
    {
        $result = $this->buildHttpQuery($this->parameters);

        return $result;

    }//end toPostdata()


    /**
     * Sign an OAuth request
     * @param string $url    HTTP URL.
     * @param string $method HTTP method.
     * @param string $cSec   Consumer secret.
     * @param string $oSec   OAuth token secret.
     * @return void
     */
    public function signRequest($url, $method, $cSec, $oSec)
    {
        $this->parameters['oauth_signature_method'] = 'HMAC-SHA1';

        $parts = array(
                  mb_strtoupper($method),
                  $url,
                  $this->buildHttpQuery($this->parameters),
                 );

        $parts = $this->urlencodeRFC3986($parts);

        $baseString = implode('&', $parts);
        $keyParts   = array(
                       $cSec,
                       $oSec,
                      );
        $keyParts   = $this->urlencodeRFC3986($keyParts);
        $key        = implode('&', $keyParts);
        $signature  = base64_encode(hash_hmac('sha1', $baseString, $key, true));

        $this->parameters['oauth_signature'] = $signature;

    }//end signRequest()


    /**
     * Encode data
     * @param string $input Unencoded input.
     * @return string Encoded output
     */
    public static function urlencodeRFC3986($input)
    {
        $result = '';

        if (is_array($input) === true) {
            $result = array_map(
                array(
                 'ABirkett\classes\OAuthRequest',
                 'urlencodeRFC3986',
                ),
                $input
            );
        }

        if (is_scalar($input) === true) {
            $result = str_replace(
                '+',
                ' ',
                str_replace('%7E', '~', rawurlencode($input))
            );
        }

        return $result;

    }//end urlencodeRFC3986()


    /**
     * Parse parameters
     *
     * This function takes a input like a=b&a=c&d=e and returns the parsed
     * parameters like this
     * array('a' => array('b','c'), 'd' => 'e')
     *
     * @param string $input Parameters.
     *
     * @return array Parsed array
     */
    public function parseParameters($input)
    {
        if (isset($input) === false) {
            return array();
        }

        $pairs = explode('&', $input);

        $parsedParams = array();
        foreach ($pairs as $pair) {
            $split = explode('=', $pair, 2);
            $param = urldecode($split[0]);
            $value = (isset($split[1]) === true) ? urldecode($split[1]) : '';

            if (isset($parsedParams[$param]) === true) {
                if (is_scalar($parsedParams[$param]) === true) {
                    $parsedParams[$param] = array($parsedParams[$param]);
                }

                $parsedParams[$param][] = $value;
            }

            if (isset($parsedParams[$param]) === false) {
                $parsedParams[$param] = $value;
            }
        }

        return $parsedParams;

    }//end parseParameters()


    /**
     * Build a HTTP query
     * @param  array $params Array of parameters.
     * @return string HTTP query string
     */
    public function buildHttpQuery(array $params)
    {
        if (empty($params) === true) {
            return '';
        }

        // Urlencode both keys and values.
        $keys   = $this->urlencodeRFC3986(array_keys($params));
        $values = $this->urlencodeRFC3986(array_values($params));
        $params = array_combine($keys, $values);

        // Parameters are sorted by name, using lexicographical byte ordering.
        // Ref: Spec: 9.1.1 (1).
        uksort($params, 'strcmp');

        $pairs = array();
        foreach ($params as $parameter => $value) {
            if (is_array($value) === true) {
                // If two or more params share the same name, store by value.
                // Ref: Spec: 9.1.1 (1).
                natsort($value);
                foreach ($value as $duplicateValue) {
                    $pairs[] = $parameter.'='.$duplicateValue;
                }
            }

            if (is_array($value) === false) {
                $pairs[] = $parameter.'='.$value;
            }
        }

        // For each parameter, the name is separated from the corresponding,
        // value by an '=' character (ASCII code 61).
        // Each name-value pair is separated by an '&' (ASCII code 38).
        $result = implode('&', $pairs);

        return $result;

    }//end buildHttpQuery()
}//end class
