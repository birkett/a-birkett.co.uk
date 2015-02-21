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
        $this->model = new \ABirkett\models\AdminAJAXRequestModel();
        switch($_POST['mode']) {
            // Edit post mode.
            case 'editpost':
                if (isset($_POST['postid']) === false
                    || is_numeric($_POST['postid']) === false
                    || isset($_POST['title']) === false
                    || isset($_POST['content']) === false
                    || isset($_POST['draft']) === false
                ) {
                    parent::badRequest(
                        'Something was rejected. Check all fields are correct.'
                    );
                } else {
                    $this->model->updatePost(
                        $_POST['postid'],
                        $_POST['title'],
                        $_POST['content'],
                        $_POST['draft']
                    );
                    parent::goodRequest('Post updated.');
                }
                break;
            // Edit page mode.
            case 'editpage':
                if (isset($_POST['pageid']) === false
                    || is_numeric($_POST['pageid']) === false
                    || isset($_POST['content']) === false
                ) {
                    parent::badRequest(
                        'Something was rejected. Check all fields are correct.'
                    );
                } else {
                    $this->model->updatePage(
                        $_POST['pageid'],
                        $_POST['content']
                    );
                    parent::goodRequest('Page updated.');
                }
                break;
            // New post mode.
            case 'newpost':
                if (isset($_POST['title']) === false
                    || isset($_POST['content']) === false
                    || isset($_POST['draft']) === false
                ) {
                    parent::badRequest(
                        'Something was rejected. Check all fields are correct.'
                    );
                } else {
                    $this->model->newPost(
                        $_POST['title'],
                        $_POST['content'],
                        $_POST['draft']
                    );
                    parent::goodRequest('Posted!');
                }
                break;
            // Add blocked IP mode.
            case 'addip':
                if (isset($_POST['ip']) === false || $_POST['ip'] === '') {
                    parent::badRequest('No address specified');
                } else {
                    $this->model->blockIP($_POST['ip']);
                    parent::goodRequest(
                        'Address '.$_POST['ip'].' was blocked'
                    );
                }
                break;
            // Remove blocked IP mode.
            case 'removeip':
                if (isset($_POST['ip']) === false || $_POST['ip'] === '') {
                    parent::badRequest('No address specified');
                } else {
                    $this->model->unblockIP($_POST['ip']);
                    parent::goodRequest(
                        'Address '.$_POST['ip'].' was unblocked'
                    );
                }
                break;
            // Change the admin password.
            case 'password':
                if (isset($_POST['cp']) === false
                    || isset($_POST['np']) === false
                    || isset($_POST['cnp']) === false
                ) {
                    parent::badRequest();
                } else {
                    if ($this->model->changePassword(
                        $_POST['cp'],
                        $_POST['np'],
                        $_POST['cnp']
                    )) {
                        parent::goodRequest('Password changed.');
                    } else {
                        parent::badRequest(
                            'Failed. Check new passwords match.'
                        );
                    }
                }
                break;
            // Login.
            case 'login':
                if (isset($_POST['username']) === true
                    && isset($_POST['password']) === true
                ) {
                    if ($this->model->checkCredentials(
                        $_POST['username'],
                        $_POST['password']
                    )) {
                        parent::goodRequest();
                    } else {
                        parent::badRequest('Incorrect username or password.');
                    }
                }
                break;
            default:
                parent::badRequest();
        }//end switch

    }//end __construct()
}//end class
