<?php
/**
* AdminAJAXRequestController - Handle private POST requests from AJAX
*
* PHP Version 5.5
*
* @category AdminControllers
* @package  PersonalWebsite
* @author   Anthony Birkett <anthony@a-birkett.co.uk>
* @license  http://opensource.org/licenses/MIT MIT
* @link     http://www.a-birkett.co.uk
*/
namespace ABirkett\controllers;

class AdminAJAXRequestController extends AJAXRequestController
{
    /**
    * Handle private POST requests from AJAX
    * @return none
    */
    public function __construct()
    {
        $this->model = new \ABirkett\models\AdminAJAXRequestModel();
        switch($_POST['mode']) {
            //Edit post mode
            case "editpost":
                if (!isset($_POST['postid'])
                    || !is_numeric($_POST['postid'])
                    || !isset($_POST['title'])
                    || !isset($_POST['content'])
                    || !isset($_POST['draft'])
                ) {
                    parent::badRequest("Something was rejected. Check all fields are correct.");
                } else {
                    $this->model->updatePost($_POST['postid'], $_POST['title'], $_POST['content'], $_POST['draft']);
                    parent::goodRequest("Post updated.");
                }
                break;
            //Edit page mode
            case "editpage":
                if (!isset($_POST['pageid']) || is_numeric($_POST['pageid'] || !isset($_POST['content']))) {
                    parent::badRequest("Something was rejected. Check all fields are correct.");
                } else {
                    $this->model->updatePage($_POST['pageid'], $_POST['content']);
                    parent::goodRequest("Page updated.");
                }
                break;
            //New post mode
            case "newpost":
                if ($_POST['title'] == "" || $_POST['content'] == "" || !isset($_POST['draft'])) {
                    parent::badRequest("Something was rejected. Check all fields are correct.");
                } else {
                    $this->model->newPost($_POST['title'], $_POST['content'], $_POST['draft']);
                    parent::goodRequest("Posted!");
                }
                break;
            //Add blocked IP mode
            case "addip":
                if (!isset($_POST['ip']) || $_POST['ip'] == "") {
                    parent::badRequest("No address specified");
                } else {
                    $this->model->blockIP($_POST['ip']);
                    parent::goodRequest("Address " . $_POST['ip'] . " was blocked");
                }
                break;
            //Remove blocked IP mode
            case "removeip":
                if (!isset($_POST['ip']) || $_POST['ip'] == "") {
                    parent::badRequest("No address specified");
                } else {
                    $this->model->unblockIP($_POST['ip']);
                    parent::goodRequest("Address " . $_POST['ip'] . " was unblocked");
                }
                break;
            //Change the admin password
            case "password":
                if (!isset($_POST['cp']) || !isset($_POST['np']) || !isset($_POST['cnp'])) {
                    parent::badRequest();
                } else {
                    if ($this->model->changePassword($_POST['cp'], $_POST['np'], $_POST['cnp'])) {
                        parent::goodRequest("Password changed.");
                    } else {
                        parent::badRequest("Failed. Check new passwords match.");
                    }
                }
                break;
            //Login
            case "login":
                if (isset($_POST['username']) && isset($_POST['password'])) {
                    if ($this->model->checkCredentials($_POST['username'], $_POST['password'])) {
                        parent::goodRequest();
                    } else {
                        parent::badRequest("Incorrect username or password.");
                    }
                }
                break;
        }
    }
}
