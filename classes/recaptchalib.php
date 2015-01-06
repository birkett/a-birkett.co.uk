<?php
/*
 * This is a PHP library that handles calling reCAPTCHA.
 *    - Documentation and latest version
 *          http://recaptcha.net/plugins/php/
 *    - Get a reCAPTCHA API Key
 *          https://www.google.com/recaptcha/admin/create
 *    - Discussion group
 *          http://groups.google.com/group/recaptcha
 *
 * Copyright (c) 2007 reCAPTCHA -- http://recaptcha.net
 * AUTHORS:
 *   Mike Crawford
 *   Ben Maurer
 */

/**
 * Encodes the given data into a query string format
 * @param $data - array of string elements to be encoded
 * @return string - encoded request
 */
function _recaptcha_qsencode($data)
{
    $req = "";
    foreach ($data as $key => $value) {
        $req .= $key . '=' . urlencode(stripslashes($value)) . '&';
    }
    // Cut the last '&'
    $req = substr($req, 0, strlen($req) - 1);
    return $req;
}

/**
 * Submits an HTTP POST to a reCAPTCHA server
 * @param string $host
 * @param string $path
 * @param array $data
 * @param int port
 * @return array response
 */
function _recaptcha_http_post($host, $path, $data, $port = 80)
{
    $req = _recaptcha_qsencode($data);

    $http_request  = "POST $path HTTP/1.0\r\n";
    $http_request .= "Host: $host\r\n";
    $http_request .= "Content-Type: application/x-www-form-urlencoded;\r\n";
    $http_request .= "Content-Length: " . strlen($req) . "\r\n";
    $http_request .= "User-Agent: reCAPTCHA/PHP\r\n";
    $http_request .= "\r\n";
    $http_request .= $req;

    $response = '';
    if (false == ($fs = @fsockopen($host, $port, $errno, $errstr, 10))) {
        die ('Could not open socket');
    }

    fwrite($fs, $http_request);

    while (!feof($fs)) {
        $response .= fgets($fs, 1160); // One TCP-IP packet
    }
    fclose($fs);
    $response = explode("\r\n\r\n", $response, 2);

    return $response;
}


/**
  * Calls an HTTP POST function to verify if the user's guess was correct
  * @param string $privkey
  * @param string $remoteip
  * @param string $challenge
  * @param string $response
  * @param array $extra_params an array of extra variables to post to the server
  * @return array containing is_valid (true / false) and error message
  */
function recaptcha_check_answer($privkey, $remoteip, $challenge, $response, $extra_params = array())
{
    if ($privkey == null || $privkey == '') {
        die (
            "To use reCAPTCHA you must get an API key from " .
            "<a href='https://www.google.com/recaptcha/admin/create'>" .
            "https://www.google.com/recaptcha/admin/create</a>"
        );
    }

    if ($remoteip == null || $remoteip == '') {
        die ("For security reasons, you must pass the remote ip to reCAPTCHA");
    }

    //discard spam submissions
    if ($challenge == null || strlen($challenge) == 0 || $response == null || strlen($response) == 0) {
        $recaptcha_response = [ 'is_valid' => false, 'error' => 'incorrect-captcha-sol' ];
        return $recaptcha_response;
    }

    $response = _recaptcha_http_post(
        "www.google.com",
        "/recaptcha/api/verify",
        array(
            'privatekey' => $privkey,
            'remoteip' => $remoteip,
            'challenge' => $challenge,
            'response' => $response
        ) + $extra_params
    );

    $answers = explode("\n", $response [1]);

    $recaptcha_response = [ 'is_valid' => true, 'error' => '' ];

    if (trim($answers [0]) != 'true') {
        $recaptcha_response['is_valid'] = false;
        $recaptcha_response['error'] = $answers [1];
    }
    return $recaptcha_response;
}
