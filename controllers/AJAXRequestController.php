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
 * PHP Version 5.4
 *
 * @category  Controllers
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\controllers;

/**
 * Handles public POST requests from AJAX, currently only "postcomment".
 *
 * Also declared here, are a set of functions for providing exit conditions.
 * goodRequest(), badRequest() and resetRequest() will send a HTTP response code
 * back to the client AJAX, allowing it to determine an action.
 *
 * @category  Controllers
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */
class AJAXRequestController
{

    /**
     * Store an instance of the model for child controllers to use
     * @var object $model
     */
    public $model;


    /**
     * Exit the script with a success HTTP code
     * @param string $message Optional message.
     * @return void
     */
    protected function goodRequest($message = '')
    {
        http_response_code(200);
        echo $message;

    }//end goodRequest()


    /**
     * Exit the script with a reset content code, used for redirecting
     * @return void
     */
    protected function resetRequest()
    {
        http_response_code(205);

    }//end resetRequest()


    /**
     * Exit the script with a failed HTTP code
     * @param string $message Optional message.
     * @return void
     */
    protected function badRequest($message = '')
    {
        http_response_code(400);
        echo $message;

    }//end badRequest()


    /**
     * Super simple helper function to validate a strings length
     * @param string  $string Input string to check.
     * @param integer $min    Minimum expected string length.
     * @param integer $max    Maximum expected string length.
     * @return boolean True on valid, false otherwise
     */
    private function strClamp($string, $min, $max)
    {
        if (strlen($string) < $min || strlen($string) > $max) {
            return false;
        }

        return true;

    }//end strClamp()


    /**
     * Handle public POST requests from AJAX
     * @return none
     */
    public function __construct()
    {
        $this->model = new \ABirkett\models\AJAXRequestModel();

        // Basic.
        $mode = filter_input(INPUT_POST, 'mode', FILTER_SANITIZE_STRING);
        // Used for comments.
        $post = filter_input(INPUT_POST, 'postid', FILTER_SANITIZE_NUMBER_INT);
        $user = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $comm = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
        $resp = filter_input(INPUT_POST, 'response', FILTER_UNSAFE_RAW);
        $cip  = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_UNSAFE_RAW);

        if ($mode === 'postcomment') {
            if (isset($user) === false
                || isset($comm) === false
            ) {
                $this->badRequest('Please fill out all details.');
                return;
            }

            if ($this->strClamp($user, 3, 20) !== true) {
                $this->badRequest('Username should be 3 - 20 characters');
                return;
            }

            if ($this->strClamp($comm, 10, 500) !== true) {
                $this->badRequest('Comment should be 10 - 500 characters');
                return;
            }

            if ($this->model->checkIP($cip) !== false) {
                $this->badRequest('Your address is blocked.');
                return;
            }

            $recaptcha = new \ABirkett\classes\Recaptcha(
                RECAPTHCA_PRIVATE_KEY,
                $cip,
                $resp
            );

            if ($recaptcha->response->success !== true) {
                $this->badRequest('Captcha verification failed');
                return;
            }

            if ($this->model->postComment($post, $user, $comm, $cip) !== true) {
                $this->badRequest('Something was rejected.');
                return;
            }

            $this->goodRequest('Comment Posted!');
        }//end if

    }//end __construct()
}//end class
