<?php
//-----------------------------------------------------------------------------
// Handle public AJAX requests
//      In: Request POST data
//      Out: Status message
//-----------------------------------------------------------------------------
namespace ABirkett;

class AJAXRequestController
{
    //-----------------------------------------------------------------------------
    // Post a new comment to the database
    //		In: Target post ID, Username, Text and IP address
    //		Out: none
    //-----------------------------------------------------------------------------
    private function postComment($postid, $username, $comment, $clientip)
    {
        GetDatabase()->runQuery(
            "INSERT INTO blog_comments(post_id, comment_username, comment_text, comment_timestamp, client_ip)" .
            " VALUES(:postid, :username, :comment, :currenttime, :clientip)",
            array(
                ":postid" => $postid,
                ":username" => $username,
                ":comment" => $comment,
                ":currenttime" => time(),
                ":clientip" => $clientip
            )
        );
    }

    public function __construct()
    {
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
                    BadRequest("Something did not send correctly.");
                }

                $p = $_POST['postid'];
                $u = strip_tags($_POST['username']); //Strip tags to avoid HTML in comments
                $c = strip_tags($_POST['comment']);
                $ip = $_SERVER['REMOTE_ADDR'];
                $ch = $_POST['challenge'];
                $resp = $_POST['response'];

                if (GetDatabase()->GetNumRows(GetPosts("single", $p, false)) != 1) {
                    BadRequest("Invalid Post ID.");
                }
                if ($u == "" || $c == "" || $ch == "" || $resp == "") {
                    BadRequest("Please fill out all details.");
                }
                if (strlen($u) < 3 || strlen($u) > 20) {
                    BadRequest("Username should be 3 - 20 characters");
                }
                if (strlen($c) < 10 || strlen($c) > 500) {
                    BadRequest("Comment should be 10 - 500 characters");
                }
                if (CheckIP($ip)) {
                    BlockedRequest("Your address is blocked. This is most likely due to spam.");
                }
                $recaptcha = new RecaptchaLib();
                $captcha = $recaptcha->checkAnswer(RECAPTHCA_PRIVATE_KEY, $ip, $ch, $resp);
                if ($captcha['is_valid'] == true) {
                    $this->postComment($p, $u, $c, $ip);
                    GoodRequest("Comment Posted!");
                } else {
                    BadRequest("Captcha verification failed");
                }
        }
    }
}
