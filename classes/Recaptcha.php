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
 * Handles the Recaptcha API calls.
 *
 * The original code here was provided in an example from Google, but was
 * rewritten to use cURL instead of fopen / fwrite.
 *
 * This works by sending a GET request to Google, containing the clients
 * response, IP address and site private key. The return value is a JSON string,
 * containing a Response object with a success boolean and error string.
 *
 * @category  Classes
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */
class Recaptcha
{

    /**
     * Store the last response
     * @var object $response
     */
    public $response;


    /**
     * Verfiy a Recaptch response
     * @param string $privkey  Recaptcha private key.
     * @param string $remoteip Client IP.
     * @param string $response Client response.
     * @return object Response class
     */
    public function __construct($privkey, $remoteip, $response)
    {
        $reply = $this->http(
            'https://www.google.com/recaptcha/api/siteverify',
            '?secret='.$privkey.'&response='.$response.'&remoteip='.$remoteip
        );

        $this->response = json_decode($reply);

    }//end __construct()


    /**
     * Send a HTTP request
     * @param  string $url  Google verification URL.
     * @param  string $data URL-encoded data.
     * @return string Response
     */
    private function http($url, $data)
    {
        $ci = curl_init();
        // Curl settings.
        curl_setopt($ci, CURLOPT_URL, $url.$data);
        curl_setopt($ci, CURLOPT_USERAGENT, 'reCAPTCHA/PHP');
        curl_setopt($ci, CURLOPT_TIMEOUT, 30);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ci);
        curl_close($ci);

        return $response;

    }//end http()
}//end class
