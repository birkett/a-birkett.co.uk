<?php
/**
 * AJAXRequestController - Handle public POST requests from AJAX
 *
 * PHP Version 5.5
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
        http_response_code(200);
        exit($m);

    }//end goodRequest()


    /**
     * Exit the script with a failed HTTP code
     * @param string $m Optional message.
     * @return void
     */
    protected function badRequest($m = '')
    {
        http_response_code(400);
        exit($m);

    }//end badRequest()


    /**
     * Handle public POST requests from AJAX
     * @return none
     */
    public function __construct()
    {
        $this->model = new \ABirkett\models\AJAXRequestModel();
        switch($_POST['mode']) {
            // Handle a new comment request.
            case 'postcomment':
                if (isset($_POST['postid']) === false
                    || is_numeric($_POST['postid']) === false
                    || isset($_POST['username']) === false
                    || isset($_POST['comment']) === false
                    || isset($_POST['challenge']) === false
                    || isset($_POST['response']) === false
                ) {
                    $this->badRequest('Something did not send correctly.');
                }

                $p = $_POST['postid'];
                // Strip HTML tags.
                $u = strip_tags($_POST['username']);
                $c = strip_tags($_POST['comment']);
                $ip = $_SERVER['REMOTE_ADDR'];
                $ch = $_POST['challenge'];
                $resp = $_POST['response'];

                $postcheck = $this->model->database->GetNumRows(
                    $this->model->getSinglePost($p)
                );

                if ($postcheck != 1) {
                    $this->badRequest('Invalid Post ID.');
                }

                if ($u === '' || $c === '' || $ch === '' || $resp === '') {
                    $this->badRequest('Please fill out all details.');
                }

                if (strlen($u) < 3 || strlen($u) > 20) {
                    $this->badRequest('Username should be 3 - 20 characters');
                }

                if (strlen($c) < 10 || strlen($c) > 500) {
                    $this->badRequest('Comment should be 10 - 500 characters');
                }

                if ($this->model->checkIP($ip) !== "0") {
                    $this->badRequest(
                        'Your address is blocked.' .
                        ' This is most likely due to spam.'
                    );
                }

                $recaptcha = new \ABirkett\classes\RecaptchaLib();
                $captcha = $recaptcha->checkAnswer(
                    RECAPTHCA_PRIVATE_KEY,
                    $ip,
                    $ch,
                    $resp
                );
                if ($captcha['is_valid'] === true) {
                    $this->model->postComment($p, $u, $c, $ip);
                    $this->goodRequest('Comment Posted!');
                } else {
                    $this->badRequest('Captcha verification failed');
                }

        }//end switch

    }//end __construct()
}//end class
