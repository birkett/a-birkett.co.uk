<?php
/**
 * RecaptchaLib - Send and process a Recaptcha request. Original code (c) Google
 *
 * PHP Version 5.5
 *
 * @category  Classes
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2014 Google
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      http://recaptcha.net
 */

namespace ABirkett\classes;

class RecaptchaLib
{


    /**
     * Encode data
     * @param  string $data Data to be encoded
     * @return string Encoded data.
     */
    private function qsEncode($data)
    {
        $req = '';
        foreach ($data as $key => $value) {
            $req .= $key.'='.urlencode(stripslashes($value)).'&';
        }

        // Cut the last '&'.
        $req = substr($req, 0, strlen($req) - 1);
        return $req;

    }//end qsEncode()


    /**
     * Send a HTTP request
     * @param  string  $host Hostname.
     * @param  string  $path Path.
     * @param  string  $data Un-encoded data.
     * @param  integer $port Port number (default 80).
     * @return string Response
     */
    private function httpPost($host, $path, $data, $port = 80)
    {
        $req = $this->qsEncode($data);

        $httpRequest  = "POST $path HTTP/1.0\r\n";
        $httpRequest .= "Host: $host\r\n";
        $httpRequest .= "Content-Type: application/x-www-form-urlencoded;\r\n";
        $httpRequest .= 'Content-Length: ' . strlen($req) . "\r\n";
        $httpRequest .= "User-Agent: reCAPTCHA/PHP\r\n";
        $httpRequest .= "\r\n";
        $httpRequest .= $req;

        $response = '';
        if (false === ($fs = @fsockopen($host, $port, $errno, $errstr, 10))) {
            die ('Could not open socket');
        }

        fwrite($fs, $httpRequest);

        while (!feof($fs)) {
            // One TCP-IP packet.
            $response .= fgets($fs, 1160);
        }
        fclose($fs);
        $response = explode("\r\n\r\n", $response, 2);

        return $response;

    }//end httpPost()


    /**
     * Verfiy a Recaptch challenge
     * @param string $privkey   Recaptcha private key.
     * @param string $remoteip  Client IP.
     * @param string $challenge Challenge.
     * @param string $response  Server response.
     * @return array Response array
     */
    public function checkAnswer($privkey, $remoteip, $challenge, $response)
    {
        $reply = $this->httpPost(
            'www.google.com',
            '/recaptcha/api/verify',
            array(
                'privatekey' => $privkey,
                'remoteip'   => $remoteip,
                'challenge'  => $challenge,
                'response'   => $response
            )
        );

        $answers = explode("\n", $reply[1]);
        $recaptchaResponse = [ 'is_valid' => true, 'error' => '' ];
        if (trim($answers[0]) !== 'true') {
            $recaptchaResponse['is_valid'] = false;
            $recaptchaResponse['error'] = $answers[1];
        }

        return $recaptchaResponse;

    }//end checkAnswer()
}//end class
