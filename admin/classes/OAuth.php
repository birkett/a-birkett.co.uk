<?php
class OAuthConsumer
{
    public $key;
    public $secret;

    public function __construct($key, $secret, $callback_url = null)
    {
        $this->key = $key;
        $this->secret = $secret;
        $this->callback_url = $callback_url;
    }

    public function __toString()
    {
        return "OAuthConsumer[key=$this->key,secret=$this->secret]";
    }
}

class OAuthToken
{
    // access tokens and request tokens
    public $key;
    public $secret;

    /**
    * key = the token
    * secret = the token secret
    */
    public function __construct($key, $secret)
    {
        $this->key = $key;
        $this->secret = $secret;
    }

    /**
    * generates the basic string serialization of a token that a server
    * would respond to request_token and access_token calls with
    */
    public function __toString()
    {
        return "oauth_token=" .
        OAuthUtil::urlencode_rfc3986($this->key) .
        "&oauth_token_secret=" .
        OAuthUtil::urlencode_rfc3986($this->secret);
    }
}


/**
* The HMAC-SHA1 signature method uses the HMAC-SHA1 signature algorithm as defined in [RFC2104]
* where the Signature Base String is the text and the key is the concatenated values (each first
* encoded per Parameter Encoding) of the Consumer Secret and Token Secret, separated by an '&'
* character (ASCII code 38) even if empty.
*   - Chapter 9.2 ("HMAC-SHA1")
*/
class OAuthSignatureMethodHMACSHA1
{
    public function getName()
    {
        return "HMAC-SHA1";
    }

    public function buildSignature($request, $consumer, $token)
    {
        $base_string = $request->getSignatureBaseString();
        $request->base_string = $base_string;

        $key_parts = array(
            $consumer->secret,
            ($token) ? $token->secret : ""
        );

        $key_parts = OAuthUtil::urlencodeRFC3986($key_parts);
        $key = implode('&', $key_parts);

        return base64_encode(hash_hmac('sha1', $base_string, $key, true));
    }

    public function checkSignature($request, $consumer, $token, $signature)
    {
        $built = $this->buildSignature($request, $consumer, $token);
        return $built == $signature;
    }
}


class OAuthRequest
{
    private $parameters;
    private $http_method;
    private $http_url;
    // for debug purposes
    public $base_string;
    public static $version = '1.0';
    public static $POST_INPUT = 'php://input';

    public function __construct($http_method, $http_url, $parameters = null)
    {
        @$parameters or $parameters = array();
        $parameters = array_merge(OAuthUtil::parseParameters(parse_url($http_url, PHP_URL_QUERY)), $parameters);
        $this->parameters = $parameters;
        $this->http_method = $http_method;
        $this->http_url = $http_url;
    }


    /**
    * attempt to build up a request from what was passed to the server
    */
    public static function fromRequest($http_method = null, $http_url = null, $parameters = null)
    {
        $scheme = (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != "on")
        ? 'http'
        : 'https';
        @$http_url or $http_url = $scheme .
                  '://' . $_SERVER['HTTP_HOST'] .
                  ':' .
                  $_SERVER['SERVER_PORT'] .
                  $_SERVER['REQUEST_URI'];
        @$http_method or $http_method = $_SERVER['REQUEST_METHOD'];

        // We weren't handed any parameters, so let's find the ones relevant to
        // this request.
        // If you run XML-RPC or similar you should use this to provide your own
        // parsed parameter-list
        if (!$parameters) {
            // Find request headers
            $request_headers = OAuthUtil::get_headers();

            // Parse the query-string to find GET parameters
            $parameters = OAuthUtil::parse_parameters($_SERVER['QUERY_STRING']);

            // It's a POST request of the proper content-type, so parse POST
            // parameters and add those overriding any duplicates from GET
            if (
                $http_method == "POST"
                && @strstr($request_headers["Content-Type"], "application/x-www-form-urlencoded")
            ) {
                $post_data = OAuthUtil::parse_parameters(
                    file_get_contents(self::$POST_INPUT)
                );
                $parameters = array_merge($parameters, $post_data);
            }

            // We have a Authorization-header with OAuth data. Parse the header
            // and add those overriding any duplicates from GET or POST
            if (@substr($request_headers['Authorization'], 0, 6) == "OAuth ") {
                $header_parameters = OAuthUtil::split_header(
                    $request_headers['Authorization']
                );
                $parameters = array_merge($parameters, $header_parameters);
            }
        }
        return new OAuthRequest($http_method, $http_url, $parameters);
    }

    /**
    * pretty much a helper function to set up the request
    */
    public static function fromConsumerAndToken($consumer, $token, $http_method, $http_url, $parameters = null)
    {
        @$parameters or $parameters = array();
        $defaults = array("oauth_version" => OAuthRequest::$version,
          "oauth_nonce" => OAuthRequest::generateNonce(),
          "oauth_timestamp" => OAuthRequest::generateTimestamp(),
          "oauth_consumer_key" => $consumer->key);
        if ($token) {
            $defaults['oauth_token'] = $token->key;
        }
        $parameters = array_merge($defaults, $parameters);

        return new OAuthRequest($http_method, $http_url, $parameters);
    }

    public function setParameter($name, $value, $allow_duplicates = true)
    {
        if ($allow_duplicates && isset($this->parameters[$name])) {
            // We have already added parameter(s) with this name, so add to the list
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

    public function getParameter($name)
    {
        return isset($this->parameters[$name]) ? $this->parameters[$name] : null;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

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

        return OAuthUtil::buildHttpQuery($params);
    }

    /**
    * Returns the base string of this request
    *
    * The base string defined as the method, the url
    * and the parameters (normalized), each urlencoded
    * and the concated with &.
    */
    public function getSignatureBaseString()
    {
        $parts = array(
        $this->getNormalizedHttpMethod(),
        $this->getNormalizedHttpUrl(),
        $this->getSignableParameters()
        );

        $parts = OAuthUtil::urlencodeRFC3986($parts);

        return implode('&', $parts);
    }

    /**
    * just uppercases the http method
    */
    public function getNormalizedHttpMethod()
    {
        return strtoupper($this->http_method);
    }

    /**
    * parses the url and rebuilds it to be
    * scheme://host/path
    */
    public function getNormalizedHttpUrl()
    {
        $parts = parse_url($this->http_url);

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
    * builds a url usable for a GET request
    */
    public function toUrl()
    {
        $post_data = $this->toPostdata();
        $out = $this->getNormalizedHttpUrl();
        if ($post_data) {
            $out .= '?'.$post_data;
        }
        return $out;
    }

    /**
    * builds the data one would send in a POST request
    */
    public function toPostdata()
    {
        return OAuthUtil::buildHttpQuery($this->parameters);
    }

    /**
    * builds the Authorization: header
    */
    public function toHeader($realm = null)
    {
        $first = true;
        if ($realm) {
            $out = 'Authorization: OAuth realm="' . OAuthUtil::urlencodeRFC3986($realm) . '"';
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
            $out .= OAuthUtil::urlencodeRFC3986($k) .
            '="' .
            OAuthUtil::urlencodeRFC3986($v) .
            '"';
            $first = false;
        }
        return $out;
    }

    public function __toString()
    {
        return $this->toUrl();
    }


    public function signRequest($signature_method, $consumer, $token)
    {
        $this->setParameter(
            "oauth_signature_method",
            $signature_method->getName(),
            false
        );
        $signature = $this->buildSignature($signature_method, $consumer, $token);
        $this->setParameter("oauth_signature", $signature, false);
    }

    public function buildSignature($signature_method, $consumer, $token)
    {
        $signature = $signature_method->buildSignature($this, $consumer, $token);
        return $signature;
    }

    /**
    * util function: current timestamp
    */
    private static function generateTimestamp()
    {
        return time();
    }

    /**
    * util function: current nonce
    */
    private static function generateNonce()
    {
        $mt = microtime();
        $rand = mt_rand();

        return md5($mt . $rand); // md5s look nicer than numbers
    }
}

class OAuthUtil
{
    public static function urlencodeRFC3986($input)
    {
        if (is_array($input)) {
            return array_map(array('OAuthUtil', 'urlencodeRFC3986'), $input);
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


    // This decode function isn't taking into consideration the above
    // modifications to the encoding process. However, this method doesn't
    // seem to be used anywhere so leaving it as is.
    public static function urldecodeRFC3986($string)
    {
        return urldecode($string);
    }

    // Utility function for turning the Authorization: header into
    // parameters, has to do some unescaping
    // Can filter out any non-oauth parameters if needed (default behaviour)
    public static function splitHeader($header, $only_allow_oauth_parameters = true)
    {
        $pattern = '/(([-_a-z]*)=("([^"]*)"|([^,]*)),?)/';
        $offset = 0;
        $params = array();
        while (preg_match($pattern, $header, $matches, PREG_OFFSET_CAPTURE, $offset) > 0) {
            $match = $matches[0];
            $header_name = $matches[2][0];
            $header_content = (isset($matches[5])) ? $matches[5][0] : $matches[4][0];
            if (preg_match('/^oauth_/', $header_name) || !$only_allow_oauth_parameters) {
                $params[$header_name] = OAuthUtil::urldecodeRFC3986($header_content);
            }
            $offset = $match[1] + strlen($match[0]);
        }

        if (isset($params['realm'])) {
            unset($params['realm']);
        }

        return $params;
    }

    // helper to try to sort out headers for people who aren't running apache
    public static function getHeaders()
    {
        if (function_exists('apache_request_headers')) {
            // we need this to get the actual Authorization: header
            // because apache tends to tell us it doesn't exist
            $headers = apache_request_headers();

            // sanitize the output of apache_request_headers because
            // we always want the keys to be Cased-Like-This and arh()
            // returns the headers in the same case as they are in the
            // request
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
            // otherwise we don't have apache and are just going to have to hope
            // that $_SERVER actually contains what we need
            $out = array();
            if (isset($_SERVER['CONTENT_TYPE'])) {
                $out['Content-Type'] = $_SERVER['CONTENT_TYPE'];
            }
            if (isset($_ENV['CONTENT_TYPE'])) {
                $out['Content-Type'] = $_ENV['CONTENT_TYPE'];
            }

            foreach ($_SERVER as $key => $value) {
                if (substr($key, 0, 5) == "HTTP_") {
                    // this is chaos, basically it is just there to capitalize the first
                    // letter of every word that is not an initial HTTP and strip HTTP
                    // code from przemek
                    $key = str_replace(
                        " ",
                        "-",
                        ucwords(strtolower(str_replace("_", " ", substr($key, 5))))
                    );
                    $out[$key] = $value;
                }
            }
        }
        return $out;
    }

    // This function takes a input like a=b&a=c&d=e and returns the parsed
    // parameters like this
    // array('a' => array('b','c'), 'd' => 'e')
    public static function parseParameters($input)
    {
        if (!isset($input) || !$input) {
            return array();
        }
        $pairs = explode('&', $input);

        $parsed_parameters = array();
        foreach ($pairs as $pair) {
            $split = explode('=', $pair, 2);
            $parameter = OAuthUtil::urldecodeRFC3986($split[0]);
            $value = isset($split[1]) ? OAuthUtil::urldecodeRFC3986($split[1]) : '';

            if (isset($parsed_parameters[$parameter])) {
                // We have already recieved parameter(s) with this name, so add to the list
                // of parameters with this name

                if (is_scalar($parsed_parameters[$parameter])) {
                    // This is the first duplicate, so transform scalar (string) into an array
                    // so we can add the duplicates
                    $parsed_parameters[$parameter] = array($parsed_parameters[$parameter]);
                }

                $parsed_parameters[$parameter][] = $value;
            } else {
                $parsed_parameters[$parameter] = $value;
            }
        }
        return $parsed_parameters;
    }

    public static function buildHttpQuery($params)
    {
        if (!$params) {
            return '';
        }
        // Urlencode both keys and values
        $keys = OAuthUtil::urlencodeRFC3986(array_keys($params));
        $values = OAuthUtil::urlencodeRFC3986(array_values($params));
        $params = array_combine($keys, $values);

        // Parameters are sorted by name, using lexicographical byte value ordering.
        // Ref: Spec: 9.1.1 (1)
        uksort($params, 'strcmp');

        $pairs = array();
        foreach ($params as $parameter => $value) {
            if (is_array($value)) {
                // If two or more parameters share the same name, they are sorted by their value
                // Ref: Spec: 9.1.1 (1)
                natsort($value);
                foreach ($value as $duplicate_value) {
                    $pairs[] = $parameter . '=' . $duplicate_value;
                }
            } else {
                $pairs[] = $parameter . '=' . $value;
            }
        }
        // For each parameter, the name is separated from the corresponding value by an '=' character (ASCII code 61)
        // Each name-value pair is separated by an '&' character (ASCII code 38)
        return implode('&', $pairs);
    }
}
