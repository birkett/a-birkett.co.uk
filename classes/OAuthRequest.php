<?php
/**
 * PHP OAuth request class
 *
 * PHP Version 5.3
 *
 * @category  Classes
 * @package   PersonalWebsite
 * @author    Andy Smith <unknown@unknown.com>
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2014 Andy Smith
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      http://term.ie
 */

namespace ABirkett\classes;

class OAuthRequest
{

    /**
     * Request parameters array
     * @var array $parameters
     */
    private $parameters;

    /**
     * Request method
     * @var string $httpMethod
     */
    private $httpMethod;

    /**
     * Request URL
     * @var string $httpUrl
     */
    private $httpUrl;


    /**
     * Create an OAuth request
     * @param  string $cKey       Consumer key.
     * @param  string $oToken     OAuth token.
     * @param  string $httpMethod Request method.
     * @param  string $httpUrl    Request URL.
     * @param  array  $params     Additional parameters as array.
     * @return object OAuthRequest instance
     */
    public function __construct($cKey, $oToken, $httpMethod, $httpUrl, $params)
    {
        @$params || $params = array();
        $defaults = array(
            'oauth_version' => '1.0',
            'oauth_nonce' => md5(microtime() . mt_rand()),
            'oauth_timestamp' => time(),
            'oauth_consumer_key' => $cKey,
            'oauth_token' => $oToken,
        );

        $params = array_merge($defaults, $params);
        $params = array_merge(
            $this->parseParameters(parse_url($httpUrl, PHP_URL_QUERY)),
            $params
        );
        $this->parameters = $params;
        $this->httpMethod = $httpMethod;
        $this->httpUrl = $httpUrl;

    }//end __construct()


    /**
     * Set a request parameter
     * @param string $name            Parameter name.
     * @param string $value           Parameter value.
     * @param bool   $allowDuplicates Boolean to allow duplicates in the array.
     * @return none
     */
    public function setParameter($name, $value, $allowDuplicates = true)
    {
        if ($allowDuplicates && isset($this->parameters[$name]) === true) {
            // Already added parameter(s) with this name, so add to the list.
            if (is_scalar($this->parameters[$name]) === true) {
                // This is the first duplicate, so transform scalar (string),
                // into an array so we can add the duplicates.
                $this->parameters[$name] = array($this->parameters[$name]);
            }

            $this->parameters[$name][] = $value;
        } else {
                $this->parameters[$name] = $value;
        }

    }//end setParameter()


    /**
     * The request parameters, sorted and concatenated into a normalized string.
     * @return string
     */
    public function getSignableParameters()
    {
        // Grab all parameters
        $params = $this->parameters;

        // Remove oauth_signature if present.
        // Ref: Spec: 9.1.1 ("The oauth_signature parameter MUST be excluded.").
        if (isset($params['oauth_signature']) === true) {
            unset($params['oauth_signature']);
        }

        return $this->buildHttpQuery($params);

    }//end getSignableParameters()


    /**
     * Returns the base string of this request
     *
     * The base string defined as the method, the url
     * and the parameters (normalized), each urlencoded
     * and the concated with &.
     *
     * @return string
     */
    public function getSignatureBaseString()
    {
        $parts = array(
            $this->getNormalizedHttpMethod(),
            $this->getNormalizedHttpUrl(),
            $this->getSignableParameters()
        );

        $parts = $this->urlencodeRFC3986($parts);

        return implode('&', $parts);

    }//end getSignatureBaseString()


    /**
     * Just uppercases the http method
     * @return string Uppercase method
     */
    public function getNormalizedHttpMethod()
    {
        return strtoupper($this->httpMethod);

    }//end getNormalizedHttpMethod()


    /**
     * Parses the url and rebuilds it to be scheme://host/path
     * @return string Normalized URL
     */
    public function getNormalizedHttpUrl()
    {
        $parts = parse_url($this->httpUrl);

        $port = @$parts['port'];
        $scheme = $parts['scheme'];
        $host = $parts['host'];
        $path = @$parts['path'];

        $port or $port = ($scheme === 'https') ? '443' : '80';

        if (($scheme === 'https' && $port !== '443')
            || ($scheme === 'http' && $port !== '80')
        ) {
            $host = "$host:$port";
        }
        return "$scheme://$host$path";

    }//end getNormalizedHttpUrl()


    /**
     * Builds a URL usable for a GET request
     * @return string URL
     */
    public function toUrl()
    {
        $postData = $this->toPostdata();
        $out = $this->getNormalizedHttpUrl();
        if ($postData) {
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
        return $this->buildHttpQuery($this->parameters);

    }//end toPostdata()


    /**
     * Sign an OAuth request
     * @param string $cSec Consumer secret.
     * @param string $oSec OAuth token secret.
     * @return none
     */
    public function signRequest($cSec, $oSec)
    {
        $this->setParameter('oauth_signature_method', 'HMAC-SHA1', false);

        $baseString = $this->getSignatureBaseString();

        $keyParts = array(
            $cSec,
            $oSec,
        );

        $keyParts = $this->urlencodeRFC3986($keyParts);
        $key = implode('&', $keyParts);

        $signature = base64_encode(hash_hmac('sha1', $baseString, $key, true));

        $this->setParameter('oauth_signature', $signature, false);

    }//end signRequest()


    /**
     * Encode data
     * @param string $input Unencoded input.
     * @return string Encoded output
     */
    public static function urlencodeRFC3986($input)
    {
        if (is_array($input)) {
            return array_map(
                array('ABirkett\classes\OAuthRequest', 'urlencodeRFC3986'),
                $input
            );
        } elseif (is_scalar($input)) {
            return str_replace(
                '+',
                ' ',
                str_replace('%7E', '~', rawurlencode($input))
            );
        } else {
            return '';
        }

    }//end urlencodeRFC3986()


    /**
     * Parse parameters
     *
     * This function takes a input like a=b&a=c&d=e and returns the parsed
     * parameters like this
     * array('a' => array('b','c'), 'd' => 'e')
     *
     * @param  array $input Parameters array.
     * @return array Parsed parameters array
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
            $value = isset($split[1]) ? urldecode($split[1]) : '';

            if (isset($parsedParams[$param])) {
                if (is_scalar($parsedParams[$param])) {
                    $parsedParams[$param] = array($parsedParams[$param]);
                }
                $parsedParams[$param][] = $value;
            } else {
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
    public function buildHttpQuery($params)
    {
        if (!$params) {
            return '';
        }
        // Urlencode both keys and values
        $keys = $this->urlencodeRFC3986(array_keys($params));
        $values = $this->urlencodeRFC3986(array_values($params));
        $params = array_combine($keys, $values);

        // Parameters are sorted by name, using lexicographical byte ordering.
        // Ref: Spec: 9.1.1 (1).
        uksort($params, 'strcmp');

        $pairs = array();
        foreach ($params as $parameter => $value) {
            if (is_array($value)) {
                // If two or more params share the same name, store by value.
                // Ref: Spec: 9.1.1 (1).
                natsort($value);
                foreach ($value as $duplicateValue) {
                    $pairs[] = $parameter.'='.$duplicateValue;
                }
            } else {
                $pairs[] = $parameter.'='.$value;
            }
        }

        // For each parameter, the name is separated from the corresponding,
        // value by an '=' character (ASCII code 61).
        // Each name-value pair is separated by an '&' (ASCII code 38).
        return implode('&', $pairs);

    }//end buildHttpQuery()
}//end class
