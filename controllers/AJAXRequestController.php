<?php
//-----------------------------------------------------------------------------
// Handle public AJAX requests
//      In: Request POST data
//      Out: Status message
//-----------------------------------------------------------------------------
namespace ABirkett\controllers;

class AJAXRequestController
{
    private $model;

    //-----------------------------------------------------------------------------
    // Good and Bad request exits
    //		In: none
    //		Out: Exits script with a response code, printing an optional message
    //-----------------------------------------------------------------------------
    protected function goodRequest($m = "")
    {
        http_response_code(200);
        exit($m);
    }

    protected function badRequest($m = "")
    {
        http_response_code(400);
        exit($m);
    }

    public function __construct()
    {
        $this->model = new \ABirkett\models\AJAXRequestModel();
        switch($_POST['mode']) {
            //Handle a new comment request
            case "postcomment":
                if (
                    !isset($_POST['postid']) ||
                    !is_numeric($_POST['postid']) ||
                    !isset($_POST['username']) ||
                    !isset($_POST['comment']) ||
                    !isset($_POST['challenge']) ||
                    !isset($_POST['response'])
                ) {
                    $this->badRequest("Something did not send correctly.");
                }

                $p = $_POST['postid'];
                $u = strip_tags($_POST['username']); //Strip tags to avoid HTML in comments
                $c = strip_tags($_POST['comment']);
                $ip = $_SERVER['REMOTE_ADDR'];
                $ch = $_POST['challenge'];
                $resp = $_POST['response'];

                if ($this->model->database->GetNumRows($this->model->getSinglePost($p)) != 1) {
                    $this->badRequest("Invalid Post ID.");
                }
                if ($u == "" || $c == "" || $ch == "" || $resp == "") {
                    $this->badRequest("Please fill out all details.");
                }
                if (strlen($u) < 3 || strlen($u) > 20) {
                    $this->badRequest("Username should be 3 - 20 characters");
                }
                if (strlen($c) < 10 || strlen($c) > 500) {
                    $this->badRequest("Comment should be 10 - 500 characters");
                }
                if ($this->model->checkIP($ip) != 0) {
                    $this->badRequest("Your address is blocked. This is most likely due to spam.");
                }
                $recaptcha = new \ABirkett\classes\RecaptchaLib();
                $captcha = $recaptcha->checkAnswer(RECAPTHCA_PRIVATE_KEY, $ip, $ch, $resp);
                if ($captcha['is_valid'] == true) {
                    $this->model->postComment($p, $u, $c, $ip);
                    $this->goodRequest("Comment Posted!");
                } else {
                    $this->badRequest("Captcha verification failed");
                }
        }
    }
}
