<?php
/**
 * AJAXRequestController - Handle public POST requests from AJAX
 *
 * PHP Version 5.3
 *
 * @category  Controllers
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\controllers;

class AJAXRequestController
{

    /**
     * Store an instance of the model for child controllers to use
     * @var object $model
     */
    public $model;


    /**
     * Exit the script with a success HTTP code
     * @param string $m Optional message.
     * @return void
     */
    protected function goodRequest($m = '')
    {
        if (function_exists("http_response_code") === true) {
            http_response_code(200);
        } else {
            header("HTTP/1.0 200 OK", true, 200);
        }
        exit($m);

    }//end goodRequest()


    /**
     * Exit the script with a failed HTTP code
     * @param string $m Optional message.
     * @return void
     */
    protected function badRequest($m = '')
    {
        if (function_exists("http_response_code") === true) {
            http_response_code(400);
        } else {
            header("HTTP/1.0 400 Bad Request", true, 400);
        }
        exit($m);

    }//end badRequest()


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
        $chal = filter_input(INPUT_POST, 'challenge', FILTER_UNSAFE_RAW);
        $resp = filter_input(INPUT_POST, 'response', FILTER_UNSAFE_RAW);
        $ip   = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_UNSAFE_RAW);

        if ($mode === 'postcomment') {
            if (isset($post) === false
                || isset($user) === false
                || isset($comm)  === false
                || isset($chal) === false
                || isset($resp) === false
            ) {
                $this->badRequest('Something did not send correctly.');
            }

            $postcheck = $this->model->database->GetNumRows(
                $this->model->getSinglePost($post)
            );

            if ($postcheck !== 1) {
                $this->badRequest('Invalid Post ID.');
            }

            if ($user === ''
                || $comm === ''
                || $chal === ''
                || $resp === ''
            ) {
                $this->badRequest('Please fill out all details.');
            }

            if (strlen($user) < 3 || strlen($user) > 20) {
                $this->badRequest('Username should be 3 - 20 characters');
            }

            if (strlen($chal) < 10 || strlen($chal) > 500) {
                $this->badRequest('Comment should be 10 - 500 characters');
            }

            if ($this->model->checkIP($ip) !== "0") {
                $this->badRequest(
                    'Your address is blocked, likely due to spam.'
                );
            }

            $recaptcha = new \ABirkett\classes\RecaptchaLib();
            $captcha   = $recaptcha->checkAnswer(
                RECAPTHCA_PRIVATE_KEY,
                $ip,
                $chal,
                $resp
            );
            if ($captcha['is_valid'] === true) {
                $this->model->postComment($post, $user, $comm, $ip);
                $this->goodRequest('Comment Posted!');
            } else {
                $this->badRequest('Captcha verification failed');
            }
        }//end if

    }//end __construct()
}//end class
