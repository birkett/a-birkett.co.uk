<?php
//-----------------------------------------------------------------------------
// AJAX actions.
//
//  Defines the logic for actions that can be performed from AJAX requests
//-----------------------------------------------------------------------------
require_once("config.php");
require_once("classes/database.class.php");
require_once("classes/recaptchalib.php");
require_once("functions.php");

if(isset($_POST['mode']))
{
	switch($_POST['mode'])
	{
	case "postcomment":
		if(!isset($_POST['postid']) || !is_numeric($_POST['postid']) || !isset($_POST['username']) || !isset($_POST['comment']) || !isset($_POST['challenge']) || !isset($_POST['response']))
		{ BadRequest("Something did not send correctly."); }
		$p = $_POST['postid']; $u = strip_tags($_POST['username']); $c = strip_tags($_POST['comment']); $ip = $_SERVER['REMOTE_ADDR']; $ch = $_POST['challenge']; $resp = $_POST['response'];
		
		if($u == "" || $c == "" || $ch == "" || $resp == "") { BadRequest("Please fill out all details."); }
		if(strlen($u) < 3 || strlen($u) > 20) { BadRequest("Username should be 3 - 20 characters"); }
		if(strlen($c) < 10 || strlen($c) > 500) { BadRequest("Comment should be 10 - 500 characters"); }
		if(CheckIP($ip)) { BlockedRequest("Your address is blocked. This is most likely due to spam."); }
		
		$captcha = recaptcha_check_answer(RECAPTHCA_PRIVATE_KEY, $ip, $ch, $resp);
		if($captcha->is_valid) { PostComment($p, Sanitize($u), Sanitize($c), $ip); GoodRequest(); } else {	BadRequest("Captcha verification failed"); }
	}
}
BadRequest();
?>