<?php
//-----------------------------------------------------------------------------
// Handle private, admin, AJAX requests
//      In: Request POST data
//      Out: Status message
//-----------------------------------------------------------------------------
namespace ABirkett;

class AdminAJAXRequestController extends AJAXRequestController
{
    public function __construct()
    {
        switch($_POST['mode']) {
            //Edit post mode
            case "editpost":
                if (
                    !isset($_POST['postid']) ||
                    !is_numeric($_POST['postid']) ||
                    !isset($_POST['title']) ||
                    !isset($_POST['content']) ||
                    !isset($_POST['draft'])
                ) {
                    BadRequest("Something was rejected. Check all fields are correct.");
                } else {
                    UpdatePost($_POST['postid'], $_POST['title'], $_POST['content'], $_POST['draft']);
                    GoodRequest("Post updated.");
                }
                break;
            //Edit page mode
            case "editpage":
                if (!isset($_POST['pageid']) || is_numeric($_POST['pageid'] || !isset($_POST['content']))) {
                    BadRequest("Something was rejected. Check all fields are correct.");
                } else {
                    UpdatePage($_POST['pageid'], $_POST['content']);
                    GoodRequest("Page updated.");
                }
                break;
            //New post mode
            case "newpost":
                if ($_POST['title'] == "" || $_POST['content'] == "" || !isset($_POST['draft'])) {
                    BadRequest("Something was rejected. Check all fields are correct.");
                } else {
                    NewPost($_POST['title'], $_POST['content'], $_POST['draft']);
                    GoodRequest("Posted!");
                }
                break;
            //Add blocked IP mode
            case "addip":
                if (!isset($_POST['ip']) || $_POST['ip'] == "") {
                    BadRequest("No address specified");
                } else {
                    BlockIP($_POST['ip']);
                    GoodRequest("Address " . $_POST['ip'] . " was blocked");
                }
                break;
            //Remove blocked IP mode
            case "removeip":
                if (!isset($_POST['ip']) || $_POST['ip'] == "") {
                    BadRequest("No address specified");
                } else {
                    UnblockIP($_POST['ip']);
                    GoodRequest("Address " . $_POST['ip'] . " was unblocked");
                }
                break;
            //Change the admin password
            case "password":
                if (!isset($_POST['cp']) || !isset($_POST['np']) || !isset($_POST['cnp'])) {
                    BadRequest();
                } else {
                    if (ChangePassword($_POST['cp'], $_POST['np'], $_POST['cnp'])) {
                        GoodRequest("Password changed.");
                    } else {
                        BadRequest("Failed. Check new passwords match.");
                    }
                }
                break;
        }
    }
}
