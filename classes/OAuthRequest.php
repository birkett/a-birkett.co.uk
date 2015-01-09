<?php
/**
* PHP OAuth request class
*
* PHP Version 5.5
*
* @category Classes
* @package  PersonalWebsite
* @author   Andy Smith <unknown@unknown.com>
* @author   Anthony Birkett <anthony@a-birkett.co.uk>
* @license  http://opensource.org/licenses/MIT MIT
* @link     http://term.ie
*/
namespace ABirkett\classes;

class OAuthRequest
{
    /*
    * Request parameters array
    * @var mixed[] $parameters
    */
    private $parameters;

    /*
    * Request method
    * @var string $httpMethod
    */
    private $httpMethod;

    /*
    * Request URL
    * @var string $httpUrl
    */
    private $httpUrl;

    /**
    * Create a new OAuth request
    * @param string  $httpMethod Request method
    * @param string  $httpUrl    Request URL
    * @param mixed[] $parameters Additional parameters as array
    * @return none
    */
    public function __construct($httpMethod, $httpUrl, $parameters = null)
    {
        @$parameters or $parameters = array();
        $parameters = array_merge(
            $this->parseParameters(parse_url($httpUrl, PHP_URL_QUERY)),
            $parameters
        );
        $this->parameters = $parameters;
        $this->httpMethod = $httpMethod;
        $this->httpUrl = $httpUrl;
    }

    /**
    * Pretty much a helper function to set up the request
    * @param string  $cKey       Consumer key
    * @param string  $oToken     OAuth token
    * @param string  $httpMethod Request method
    * @param string  $httpUrl    Request URL
    * @param mixed[] $parameters Additional parameters as array
    * @return object OAuthRequest instance
    */
    public static function fromConsumerAndToken(
        $cKey,
        $oToken,
        $httpMethod,
        $httpUrl,
        $parameters = null
    ) {
        @$parameters or $parameters = array();
        $defaults = array(
            "oauth_version" => "1.0",
            "oauth_nonce" => md5(microtime() . mt_rand()),
            "oauth_timestamp" => time(),
            "oauth_consumer_key" => $cKey
        );
        $defaults['oauth_token'] = $oToken;

        $parameters = array_merge($defaults, $parameters);

        return new OAuthRequest($httpMethod, $httpUrl, $parameters);
    }

    /**
    * Set a request parameter
    * @param string $name             Parameter name
    * @param string $value            Parameter value
    * @param bool   $allowDuplicates  Boolean to allow duplicates in the array
    * @return none
    */
    public function setParameter($name, $value, $allowDuplicates = true)
    {
        if ($allowDuplicates && isset($this->parameters[$name])) {
            // Already added parameter(s) with this name, so add to the list
            if (is_scalar($this->parameters[$name])) {
                // This is the first duplicate, so transform scalar (string)
                // into an array so we can add the duplicates
                $this->parameters[$name] = array($this->parameters[$name]);
            }
            $this->parameters[$name][] = $value;
        } else {
                $this->parameters[$name] = $value;
        }
    }

    /**
    * Get a request parameter
    * @param string $name Parameter name
    * @return string Parameter value
    */
    public function getParameter($name)
    {
        if (isset($this->parameters[$name])) {
            return $this->parameters[$name];
        } else {
            return null;
        }
    }

    /**
    * Get all parameters
    * @return mixed[] Array of parameters
    */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
    * Remove (unset) a parameter
    * @param string $name Parameter name
    * @return none
    */
    public function unsetParameter($name)
    {
        unset($this->parameters[$name]);
    }

    /**
    * The request parameters, sorted and concatenated into a normalized string.
    * @return string
    */
    public function getSignableParameters()
    {
        // Grab all parameters
        $params = $this->parameters;

        // Remove oauth_signature if present
        // Ref: Spec: 9.1.1 ("The oauth_signature parameter MUST be excluded.")
        if (isset($params['oauth_signature'])) {
            unset($params['oauth_signature']);
        }

        return $this->buildHttpQuery($params);
    }

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
    }

    /**
    * Just uppercases the http method
    * @return string Uppercase method
    */
    public function getNormalizedHttpMethod()
    {
        return strtoupper($this->httpMethod);
    }

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

        $port or $port = ($scheme == 'https') ? '443' : '80';

        if (
            ($scheme == 'https' && $port != '443') ||
            ($scheme == 'http' && $port != '80')
        ) {
            $host = "$host:$port";
        }
        return "$scheme://$host$path";
    }

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
    }

    /**
    * Builds the data one would send in a POST request
    * @return string Data
    */
    public function toPostdata()
    {
        return $this->buildHttpQuery($this->parameters);
    }

    /**
    * Builds the Authorization: header
    * @param string $realm Realm the request is part of
    * @return string Authorization header
    */
    public function toHeader($realm = null)
    {
        $first = true;
        if ($realm) {
            $out = 'Authorization: OAuth realm="' .
                $this->urlencodeRFC3986($realm) .
                '"';
            $first = false;
        } else {
            $out = 'Authorization: OAuth';
        }
        $total = array();
        foreach ($this->parameters as $k => $v) {
            if (substr($k, 0, 5) != "oauth") {
                continue;
            }
            //if (is_array($v)) {
            //    throw new OAuthException('Arrays not supported in headers');
            //}
            $out .= ($first) ? ' ' : ',';
            $out .= $this->urlencodeRFC3986($k) .
            '="' .
            $this->urlencodeRFC3986($v) .
            '"';
            $first = false;
        }
        return $out;
    }

    /**
    * Sign an OAuth request
    * @param string $cKey   Consumer key
    * @param string $cSec   Consumer secret
    * @param string $oToken OAuth token
    * @param string $oSec   OAuth token secret
    * @return none
    */
    public function signRequest($cKey, $cSec, $oToken, $oSec)
    {
        $this->setParameter(
            "oauth_signature_method",
            "HMAC-SHA1",
            false
        );
        $signature = $this->buildSignature($cKey, $cSec, $oToken, $oSec);
        $this->setParameter("oauth_signature", $signature, false);
    }

    /**
    * Build an OAuth request signature
    * @param string $cKey   Consumer key
    * @param string $cSec   Consumer secret
    * @param string $oToken OAuth token
    * @param string $oSec   OAuth token secret
    * @return string Signature
    */
    public function buildSignature($cKey, $cSec, $oToken, $oSec)
    {
        $baseString = $this->getSignatureBaseString();
        $this->baseString = $baseString;

        $keyParts = array(
            $cSec,
            $oSec
        );

        $keyParts = $this->urlencodeRFC3986($keyParts);
        $key = implode('&', $keyParts);

        return base64_encode(hash_hmac('sha1', $baseString, $key, true));
    }

    /**
    * Encode data
    * @param string $input Unencoded input
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
    }

    /**
    * Decode data
    *
    * This decode function isn't taking into consideration the above
    * modifications to the encoding process. However, this method doesn't
    * seem to be used anywhere so leaving it as is.
    *
    * @param string $string Encoded data
    * @return string Decoded data
    */
    public static function urldecodeRFC3986($string)
    {
        return urldecode($string);
    }

    /**
    * Split a header
    *
    * Utility function for turning the Authorization: header into
    * parameters, has to do some unescaping
    * Can filter out any non-oauth parameters if needed (default behaviour)
    *
    * @param string $header          Request header
    * @param bool   $onlyOauthParams Unknown
    * @return mixed[] Parameters array Output parameters array
    */
    public static function splitHeader($header, $onlyOauthParams = true)
    {
        $pat = '/(([-_a-z]*)=("([^"]*)"|([^,]*)),?)/';
        $off = 0;
        $params = array();
        while (preg_match($pat, $header, $m, PREG_OFFSET_CAPTURE, $off) > 0) {
            $match = $m[0];
            $headerName = $m[2][0];
            $content = (isset($m[5])) ? $m[5][0] : $m[4][0];
            if (preg_match('/^oauth_/', $headerName) || !$onlyOauthParams) {
                $params[$headerName] = $this->urldecodeRFC3986($content);
            }
            $off = $match[1] + strlen($match[0]);
        }

        if (isset($params['realm'])) {
            unset($params['realm']);
        }

        return $params;
    }

    /**
    * Helper to try to sort out headers for people who aren't running apache
    * @return string Headers
    */
    public static function getHeaders()
    {
        if (function_exists('apache_request_headers')) {
            $headers = apache_request_headers();
            $out = array();
            foreach ($headers as $key => $value) {
                $key = str_replace(
                    " ",
                    "-",
                    ucwords(strtolower(str_replace("-", " ", $key)))
                );
                $out[$key] = $value;
            }
        } else {
            $out = array();
            if (isset($_SERVER['CONTENT_TYPE'])) {
                $out['Content-Type'] = $_SERVER['CONTENT_TYPE'];
            }
            if (isset($_ENV['CONTENT_TYPE'])) {
                $out['Content-Type'] = $_ENV['CONTENT_TYPE'];
            }

            foreach ($_SERVER as $key => $value) {
                if (substr($key, 0, 5) == "HTTP_") {
                    $key = str_replace(
                        " ",
                        "-",
                        ucwords(
                            strtolower(str_replace("_", " ", substr($key, 5)))
                        )
                    );
                    $out[$key] = $value;
                }
            }
        }
        return $out;
    }

    /**
    * Parse parameters
    *
    * This function takes a input like a=b&a=c&d=e and returns the parsed
    * parameters like this
    * array('a' => array('b','c'), 'd' => 'e')
    *
    * @param mixed[] $input Parameters array
    * @return mixed[] Parsed parameters array
    */
    public static function parseParameters($input)
    {
        if (!isset($input) || !$input) {
            return array();
        }
        $pairs = explode('&', $input);

        $parsedParams = array();
        foreach ($pairs as $pair) {
            $split = explode('=', $pair, 2);
            $param = $this->urldecodeRFC3986($split[0]);
            $value = isset($split[1]) ? $this->urldecodeRFC3986($split[1]) : '';

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
    }

    /**
    * Build a HTTP query
    * @param mixed[] $params Array of parameters
    * @return string HTTP query string
    */
    public static function buildHttpQuery($params)
    {
        if (!$params) {
            return '';
        }
        // Urlencode both keys and values
        $keys = $this->urlencodeRFC3986(array_keys($params));
        $values = $this->urlencodeRFC3986(array_values($params));
        $params = array_combine($keys, $values);

        // Parameters are sorted by name, using lexicographical byte ordering.
        // Ref: Spec: 9.1.1 (1)
        uksort($params, 'strcmp');

        $pairs = array();
        foreach ($params as $parameter => $value) {
            if (is_array($value)) {
                // If two or more parameters share the same name, store by value
                // Ref: Spec: 9.1.1 (1)
                natsort($value);
                foreach ($value as $duplicateValue) {
                    $pairs[] = $parameter . '=' . $duplicateValue;
                }
            } else {
                $pairs[] = $parameter . '=' . $value;
            }
        }
        // For each parameter, the name is separated from the corresponding
        // value by an '=' character (ASCII code 61)
        // Each name-value pair is separated by an '&' character (ASCII code 38)
        return implode('&', $pairs);
    }
}
