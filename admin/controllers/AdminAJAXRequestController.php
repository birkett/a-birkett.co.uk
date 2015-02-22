<?php
/**
 * AdminAJAXRequestController - Handle private POST requests from AJAX
 *
 * PHP Version 5.5
 *
 * @category  AdminControllers
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      http://www.a-birkett.co.uk
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
        // Basics.
        $mode = filter_input(INPUT_POST, 'mode', FILTER_SANITIZE_STRING);
        // Used for post and page edits.
        $posid = filter_input(INPUT_POST, 'postid', FILTER_SANITIZE_NUMBER_INT);
        $pagid = filter_input(INPUT_POST, 'pageid', FILTER_SANITIZE_NUMBER_INT);
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $cont  = filter_input(INPUT_POST, 'content', FILTER_UNSAFE_RAW);
        $draft = filter_input(INPUT_POST, 'draft', FILTER_SANITIZE_STRING);
        // Used for the IP filter.
        $ip = filter_input(INPUT_POST, 'ip', FILTER_SANITIZE_STRING);
        // Used for the password change.
        $cp  = filter_input(INPUT_POST, 'cp', FILTER_SANITIZE_STRING);
        $np  = filter_input(INPUT_POST, 'np', FILTER_SANITIZE_STRING);
        $cnp = filter_input(INPUT_POST, 'cnp', FILTER_SANITIZE_STRING);
        // Used for the login.
        $user = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $pass = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        $this->model = new \ABirkett\models\AdminAJAXRequestModel();
        switch($mode) {
            // Edit post mode.
            case 'editpost':
                if (isset($posid) === false
                    || isset($title) === false
                    || isset($cont) === false
                    || isset($draft) === false
                ) {
                    parent::badRequest(
                        'Something was rejected. Check all fields are correct.'
                    );
                } else {
                    $this->model->updatePost($posid, $title, $cont, $draft);
                    parent::goodRequest('Post updated.');
                }
                break;

            // Edit page mode.
            case 'editpage':
                if (isset($pagid) === false || isset($cont) === false) {
                    parent::badRequest(
                        'Something was rejected. Check all fields are correct.'
                    );
                } else {
                    $this->model->updatePage($pagid, $cont);
                    parent::goodRequest('Page updated.');
                }
                break;

            // New post mode.
            case 'newpost':
                if (isset($title) === false
                    || isset($cont) === false
                    || isset($draft) === false
                ) {
                    parent::badRequest(
                        'Something was rejected. Check all fields are correct.'
                    );
                } else {
                    $this->model->newPost($title, $cont, $draft);
                    parent::goodRequest('Posted!');
                }
                break;

            // Add blocked IP mode.
            case 'addip':
                if (isset($ip) === false || $ip === '') {
                    parent::badRequest('No address specified');
                } else {
                    $this->model->blockIP($ip);
                    parent::goodRequest('Address '.$ip.' was blocked');
                }
                break;

            // Remove blocked IP mode.
            case 'removeip':
                if (isset($ip) === false || $ip === '') {
                    parent::badRequest('No address specified');
                } else {
                    $this->model->unblockIP($ip);
                    parent::goodRequest('Address '.$ip.' was unblocked');
                }
                break;

            // Change the admin password.
            case 'password':
                if (isset($cp) === false
                    || isset($np) === false
                    || isset($cnp) === false
                ) {
                    parent::badRequest();
                } else {
                    if ($this->model->changePassword($cp, $np, $cnp) === true) {
                        parent::goodRequest('Password changed.');
                    } else {
                        parent::badRequest('Failed. Check passwords match.');
                    }
                }
                break;

            // Login.
            case 'login':
                if (isset($user) === false || isset($pass) === false) {
                    parent::badRequest('Incorrect username or password.');
                } else {
                    if ($this->model->checkCredentials($user, $pass) === true) {
                        parent::goodRequest();
                    } else {
                        parent::badRequest('Incorrect username or password.');
                    }
                }
                break;

            default:
                parent::badRequest();
                break;
        }//end switch

    }//end __construct()
}//end class
