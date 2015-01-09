<?php
namespace ABirkett\classes;

class OAuthRequest
{
    private $parameters;
    private $http_method;
    private $http_url;

    public function __construct($http_method, $http_url, $parameters = null)
    {
        @$parameters or $parameters = array();
        $parameters = array_merge($this->parseParameters(parse_url($http_url, PHP_URL_QUERY)), $parameters);
        $this->parameters = $parameters;
        $this->http_method = $http_method;
        $this->http_url = $http_url;
    }

    /**
    * pretty much a helper function to set up the request
    */
    public static function fromConsumerAndToken($c_key, $o_token, $http_method, $http_url, $parameters = null)
    {
        @$parameters or $parameters = array();
        $defaults = array(
            "oauth_version" => "1.0",
            "oauth_nonce" => md5(microtime() . mt_rand()),
            "oauth_timestamp" => time(),
            "oauth_consumer_key" => $c_key
        );
        $defaults['oauth_token'] = $o_token;

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

        return $this->buildHttpQuery($params);
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

        $parts = OAuthRequest::urlencodeRFC3986($parts);

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
        return $this->buildHttpQuery($this->parameters);
    }

    /**
    * builds the Authorization: header
    */
    public function toHeader($realm = null)
    {
        $first = true;
        if ($realm) {
            $out = 'Authorization: OAuth realm="' . OAuthRequest::urlencodeRFC3986($realm) . '"';
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
            $out .= OAuthRequest::urlencodeRFC3986($k) .
            '="' .
            OAuthRequest::urlencodeRFC3986($v) .
            '"';
            $first = false;
        }
        return $out;
    }

    public function signRequest($consumer_key, $consumer_secret, $oauth_token, $oauth_secret)
    {
        $this->setParameter(
            "oauth_signature_method",
            "HMAC-SHA1",
            false
        );
        $signature = $this->buildSignature($consumer_key, $consumer_secret, $oauth_token, $oauth_secret);
        $this->setParameter("oauth_signature", $signature, false);
    }

    public function buildSignature($consumer_key, $consumer_secret, $oauth_token, $oauth_secret)
    {
        $base_string = $this->getSignatureBaseString();
        $this->base_string = $base_string;

        $key_parts = array(
            $consumer_secret,
            $oauth_secret
        );

        $key_parts = OAuthRequest::urlencodeRFC3986($key_parts);
        $key = implode('&', $key_parts);

        return base64_encode(hash_hmac('sha1', $base_string, $key, true));
    }


    public static function urlencodeRFC3986($input)
    {
        if (is_array($input)) {
            return array_map(array('ABirkett\OAuthRequest', 'urlencodeRFC3986'), $input);
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
                $params[$header_name] = OAuthRequest::urldecodeRFC3986($header_content);
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
            $headers = apache_request_headers();
            $out = array();
            foreach ($headers as $key => $value) {
                $key = str_replace(" ", "-", ucwords(strtolower(str_replace("-", " ", $key))));
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
                    $key = str_replace(" ", "-", ucwords(strtolower(str_replace("_", " ", substr($key, 5)))));
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
            $parameter = OAuthRequest::urldecodeRFC3986($split[0]);
            $value = isset($split[1]) ? OAuthRequest::urldecodeRFC3986($split[1]) : '';

            if (isset($parsed_parameters[$parameter])) {
                if (is_scalar($parsed_parameters[$parameter])) {
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
        $keys = OAuthRequest::urlencodeRFC3986(array_keys($params));
        $values = OAuthRequest::urlencodeRFC3986(array_values($params));
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
