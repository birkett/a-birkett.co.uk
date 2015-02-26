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
        // Basics.
        $mode = filter_input(INPUT_POST, 'mode', FILTER_SANITIZE_STRING);
        // Used for post and page edits.
        $posid = filter_input(INPUT_POST, 'postid', FILTER_SANITIZE_NUMBER_INT);
        $pagid = filter_input(INPUT_POST, 'pageid', FILTER_SANITIZE_NUMBER_INT);
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $cont  = filter_input(INPUT_POST, 'content', FILTER_UNSAFE_RAW);
        $draft = filter_input(INPUT_POST, 'draft', FILTER_SANITIZE_STRING);
        // Used for the IP filter.
        $ipaddress = filter_input(INPUT_POST, 'ip', FILTER_SANITIZE_STRING);
        // Used for the password change.
        $cup  = filter_input(INPUT_POST, 'cp', FILTER_SANITIZE_STRING);
        $newp = filter_input(INPUT_POST, 'np', FILTER_SANITIZE_STRING);
        $cnp  = filter_input(INPUT_POST, 'cnp', FILTER_SANITIZE_STRING);
        // Used for the login.
        $user = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $pass = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        $this->model = new \ABirkett\models\AdminAJAXRequestModel();

        // Bail if not logged in, and not requesting a login.
        if (\ABirkett\classes\SessionManager::isLoggedIn() === false
            && $mode !== 'login'
        ) {
            parent::badRequest('Not logged in.');
        }

        switch($mode) {
            // Edit post mode.
            case 'editpost':
                if ($this->model->updatePost(
                    $posid,
                    $title,
                    $cont,
                    $draft
                ) === false) {
                    parent::badRequest(
                        'Something was rejected. Check all fields are correct.'
                    );
                }

                parent::goodRequest('Post updated.');
                break;

            // Edit page mode.
            case 'editpage':
                if ($this->model->updatePage($pagid, $cont) === false) {
                    parent::badRequest(
                        'Something was rejected. Check all fields are correct.'
                    );
                }

                parent::goodRequest('Page updated.');
                break;

            // New post mode.
            case 'newpost':
                if ($this->model->newPost($title, $cont, $draft) === false) {
                    parent::badRequest(
                        'Something was rejected. Check all fields are correct.'
                    );
                }

                parent::goodRequest('Posted!');
                break;

            // Add blocked IP mode.
            case 'addip':
                if ($this->model->blockIP($ipaddress) === false) {
                    parent::badRequest('No address specified');
                }

                parent::goodRequest('Address '.$ipaddress.' was blocked');
                break;

            // Remove blocked IP mode.
            case 'removeip':
                if ($this->model->unblockIP($ipaddress) === false) {
                    parent::badRequest('No address specified');
                }

                parent::goodRequest('Address '.$ipaddress.' was unblocked');
                break;

            // Change the admin password.
            case 'password':
                if ($this->model->changePassword($cup, $newp, $cnp) === false) {
                    parent::badRequest('Failed. Check passwords match.');
                }

                parent::goodRequest('Password changed.');
                break;

            // Login.
            case 'login':
                if ($this->model->checkCredentials($user, $pass) === false) {
                    parent::badRequest('Incorrect username or password.');
                }

                // Set up the session on successful login.
                \ABirkett\classes\SessionManager::doLogin($user);
                parent::goodRequest();
                break;

            // Logout.
            case 'logout':
                \ABirkett\classes\SessionManager::doLogout();
                parent::resetRequest();
                break;

            default:
                parent::badRequest();
                break;
        }//end switch

    }//end __construct()
}//end class
