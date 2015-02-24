<?php
/**
 * Recaptcha - Send a GET request to Google to verify a Recaptcha response.
 *
 * PHP Version 5.3
 *
 * @category  Classes
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\classes;

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
