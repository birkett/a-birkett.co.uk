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
 * @category  Classes
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\classes;

/**
 * Wraps up the PHP session functions for handling user authentication.
 *
 * SessionManager handles the user login / logout, and validates the session.
 * A call to SessionManager::begin() should be one of the first calls in a
 * protected page. This will ensure that the isLoggedIn() function is available
 * immediatly after.
 *
 * doLogin() will assign the users name, User-Agent string and IP address to a
 * new session, preventing most session stealing.
 * isLoggedIn() checks this data matches what was expected.
 * An EXPIRES entry is also assigned, forcing a session to expire after a set
 * period of time (by default 1 hour, SESSION_EXPIRY_TIME).
 *
 * @category  Classes
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */
class SessionManager
{


    /**
     * Start a session
     * @return void
     */
    public static function begin()
    {
        session_name('ABirkettAdmin');
        session_set_cookie_params(SESSION_EXPIRY_TIME, '/'.ADMIN_FOLDER);
        session_start();

    }//end begin()


    /**
     * Destroy the open session
     * @return void
     */
    public static function doLogout()
    {
        session_unset();
        session_destroy();

    }//end doLogout()


    /**
     * Set a username in the session
     * @param string $user Username to store.
     * @return void
     */
    public static function doLogin($user)
    {
        $cip = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_UNSAFE_RAW);
        $cua = filter_input(INPUT_SERVER, 'HTTP_USER_AGENT', FILTER_UNSAFE_RAW);

        $_SESSION['user']    = $user;
        $_SESSION['ip']      = $cip;
        $_SESSION['ua']      = $cua;
        $_SESSION['EXPIRES'] = (time() + SESSION_EXPIRY_TIME);

        self::regenerateID();

    }//end doLogin()


    /**
     * Get the username from the session
     * @return string Username or null on not logged in
     */
    public static function getUser()
    {
        $ses = $_SESSION;

        if (isset($ses['user']) === true) {
            return $ses['user'];
        }

        return null;

    }//end getUser()


    /**
     * Is a user logged in
     * @return boolean Is logged in
     */
    public static function isLoggedIn()
    {
        $cip = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_UNSAFE_RAW);
        $cua = filter_input(INPUT_SERVER, 'HTTP_USER_AGENT', FILTER_UNSAFE_RAW);
        $ses = $_SESSION;

        if (isset($ses['user']) === false) {
            return false;
        }

        if (isset($ses['ip']) === false) {
            return false;
        }

        if (isset($ses['ua']) === false) {
            return false;
        }

        if (isset($ses['EXPIRES']) === false) {
            return false;
        }

        if ($ses['ip'] !== $cip
            || $ses['ua'] !== $cua
            || $ses['EXPIRES'] < time()
        ) {
            self::doLogout();

            return false;
        }

        // If everything passed, session is valid.
        return true;

    }//end isLoggedIn()


    /**
     * Regenerate the session ID
     * @return void
     */
    public static function regenerateID()
    {
        session_regenerate_id(true);

    }//end regenerateID()
}//end class
