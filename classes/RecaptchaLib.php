<?php
namespace ABirkett;

class RecaptchaLib
{
    private function qsEncode($data)
    {
        $req = "";
        foreach ($data as $key => $value) {
            $req .= $key . '=' . urlencode(stripslashes($value)) . '&';
        }
        $req = substr($req, 0, strlen($req) - 1); // Cut the last '&'
        return $req;
    }

    private function httpPost($host, $path, $data, $port = 80)
    {
        $req = $this->qsEncode($data);

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

    public function checkAnswer($privkey, $remoteip, $challenge, $response)
    {
        $reply = $this->httpPost(
            "www.google.com",
            "/recaptcha/api/verify",
            array(
                'privatekey' => $privkey,
                'remoteip' => $remoteip,
                'challenge' => $challenge,
                'response' => $response
            )
        );

        $answers = explode("\n", $reply[1]);

        $recaptcha_response = [ 'is_valid' => true, 'error' => '' ];

        if (trim($answers[0]) != 'true') {
            $recaptcha_response['is_valid'] = false;
            $recaptcha_response['error'] = $answers[1];
        }
        return $recaptcha_response;
    }
}
