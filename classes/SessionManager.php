<?php
/**
 * SessionManager - Handle user sessions
 *
 * PHP Version 5.3
 *
 * @category  Classes
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\classes;

class SessionManager
{


    /**
     * Start a session
     * @return void
     */
    public static function begin()
    {
        session_name('ABirkettAdmin');
        session_set_cookie_params(
            SESSION_EXPIRY_TIME,
            '/'.ADMIN_FOLDER
        );
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
        $ip = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_UNSAFE_RAW);
        $ua = filter_input(INPUT_SERVER, 'HTTP_USER_AGENT', FILTER_UNSAFE_RAW);

        $_SESSION['user']    = $user;
        $_SESSION['ip']      = $ip;
        $_SESSION['ua']      = $ua;
        $_SESSION['EXPIRES'] = time() + SESSION_EXPIRY_TIME;

        self::regenerateID();

    }//end doLogin()


    /**
     * Get the username from the session
     * @return string Username or null on not logged in
     */
    public static function getUser()
    {
        if (isset($_SESSION['user']) === true) {
            return $_SESSION['user'];
        } else {
            return null;
        }

    }//end getUser()


    /**
     * Is a user logged in
     * @return boolean Is logged in
     */
    public static function isLoggedIn()
    {
        $ip = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_UNSAFE_RAW);
        $ua = filter_input(INPUT_SERVER, 'HTTP_USER_AGENT', FILTER_UNSAFE_RAW);

        if (isset($_SESSION['user']) === false) {
            return false;
        }

        if (isset($_SESSION['ip']) === false) {
            return false;
        }

        if (isset($_SESSION['ua']) === false) {
            return false;
        }

        if (isset($_SESSION['EXPIRES']) === false) {
            return false;
        }

        if ($_SESSION['ip'] !== $ip
            || $_SESSION['ua'] !== $ua
            || $_SESSION['EXPIRES'] < time()
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
