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
 * PHP Version 5.3
 *
 * @category  AdminControllers
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\controllers;

/**
 * Hhandles private POST requests from the admin AJAX.
 *
 * This is really just the equivilant of the index.php proxy, but for POST
 * requests.
 *
 * @category  AdminControllers
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */
class AdminAJAXRequestController extends AJAXRequestController
{


    /**
     * Handle private POST requests from AJAX
     * @return none
     */
    public function __construct()
    {
        $this->model    = new \ABirkett\models\AdminAJAXRequestModel();
        $sessionManager = \ABirkett\classes\SessionManager::getInstance();

        // Basics.
        $mode = $this->model->getPostVar('mode', FILTER_SANITIZE_STRING);
        // Used for post and page edits.
        $posid = $this->model->getPostVar('postid', FILTER_SANITIZE_NUMBER_INT);
        $pagid = $this->model->getPostVar('pageid', FILTER_SANITIZE_NUMBER_INT);
        $title = $this->model->getPostVar('title', FILTER_SANITIZE_STRING);
        $cont  = $this->model->getPostVar('content', FILTER_UNSAFE_RAW);
        $draft = $this->model->getPostVar('draft', FILTER_SANITIZE_STRING);
        // Used for the IP filter.
        $ipaddress = $this->model->getPostVar('ip', FILTER_VALIDATE_IP);
        // Used for the password change.
        $cup  = $this->model->getPostVar('cp', FILTER_SANITIZE_STRING);
        $newp = $this->model->getPostVar('np', FILTER_SANITIZE_STRING);
        $cnp  = $this->model->getPostVar('cnp', FILTER_SANITIZE_STRING);
        // Used for the login.
        $user = $this->model->getPostVar('username', FILTER_SANITIZE_STRING);
        $pass = $this->model->getPostVar('password', FILTER_SANITIZE_STRING);

        // Bail if not logged in, and not requesting a login.
        if ($sessionManager->isLoggedIn() === false && $mode !== 'login') {
            $this->badRequest('Not logged in.');
            return;
        }

        switch($mode) {
            // Edit post mode.
            case 'editpost':
                $this->actionEditPost($posid, $title, $cont, $draft);
                break;

            // Edit page mode.
            case 'editpage':
                $this->actionEditPage($pagid, $cont);
                break;

            // New post mode.
            case 'newpost':
                $this->actionNewPost($title, $cont, $draft);
                break;

            // Add blocked IP mode.
            case 'addip':
                $this->actionBlockIP($ipaddress);
                break;

            // Remove blocked IP mode.
            case 'removeip':
                $this->actionUnblockIP($ipaddress);
                break;

            // Change the admin password.
            case 'password':
                $this->actionChangePassword($sessionManager, $cup, $newp, $cnp);
                break;

            // Login.
            case 'login':
                $this->actionLogin($sessionManager, $user, $pass);
                break;

            // Logout.
            case 'logout':
                $this->actionLogout($sessionManager);
                break;

            // Default, send a bad request response.
            default:
                $this->badRequest('');
                break;
        }//end switch

    }//end __construct()


    /**
     * Handle the editpost request
     * @param integer $posid Post ID to edit.
     * @param string  $title Post title.
     * @param string  $cont  Post content.
     * @param string  $draft Post draft status.
     * @return void
     */
    private function actionEditPost($posid, $title, $cont, $draft)
    {
        if ($this->model->updatePost($posid, $title, $cont, $draft) === false) {
            $this->badRequest('Bad request. Check all fields are correct.');
            return;
        }

        $this->goodRequest('Post updated.');

    }//end actionEditPost()


    /**
     * Handle the editpage request
     * @param integer $pageid  Page ID to edit.
     * @param string  $content Page content.
     * @return void
     */
    private function actionEditPage($pageid, $content)
    {
        if ($this->model->updatePage($pageid, $content) === false) {
            $this->badRequest('Bad request. Check all fields are correct.');
            return;
        }

        $this->goodRequest('Page updated.');

    }//end actionEditPage()


    /**
     * Handle the newpost request
     * @param string $title   Post title.
     * @param string $content Post content.
     * @param string $draft   Post draft status.
     * @return void
     */
    private function actionNewPost($title, $content, $draft)
    {
        if ($this->model->newPost($title, $content, $draft) === false) {
            $this->badRequest('Bad request. Check all fields are correct.');
            return;
        }

        $this->goodRequest('Posted!');

    }//end actionNewPost()


    /**
     * Handle the addip request
     * @param string $ipaddress Address to blacklist.
     * @return void
     */
    private function actionBlockIP($ipaddress)
    {
        if ($this->model->blockIP($ipaddress) === false) {
            $this->badRequest('Invalid address specified');
            return;
        }

        $this->goodRequest('Address '.$ipaddress.' was blocked');

    }//end actionBlockIP()


    /**
     * Handle the removeip request
     * @param string $ipaddress Address to remove from the blacklist.
     * @return void
     */
    private function actionUnblockIP($ipaddress)
    {
        if ($this->model->unblockIP($ipaddress) === false) {
            $this->badRequest('Invalid address specified');
            return;
        }

        $this->goodRequest('Address '.$ipaddress.' was unblocked');

    }//end actionUnblockIP()


    /**
     * Handle the password request
     * @param object $sessionManager SessionManager instance to use.
     * @param string $cup            Current users password.
     * @param string $new            New users password.
     * @param string $conf           New users password again to confirm.
     * @return void
     */
    private function actionChangePassword($sessionManager, $cup, $new, $conf)
    {
        $user = $sessionManager->getVar('user');
        if ($this->model->changePassword($user, $cup, $new, $conf) === false) {
            $this->badRequest('Failed. Check passwords match.');
            return;
        }

        $sessionManager->regenerateID();
        $this->goodRequest('Password changed.');

    }//end actionChangePassword()
}//end class
