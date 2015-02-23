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
        session_start();

    }//end begin()


    /**
     * Destroy the open session
     * @return void
     */
    public static function destroy()
    {
        session_unset();
        session_destroy();

    }//end destroy()


    /**
     * Set a username in the session
     * @param string $user Username to store.
     * @return void
     */
    public static function setUser($user)
    {
        $_SESSION['user'] = $user;

    }//end setUser()


    /**
     * Get the username from the session
     * @return string Username
     */
    public static function getUser()
    {
        return $_SESSION['user'];

    }//end getUser()


    /**
     * Is a user logged in
     * @return boolean Is logged in
     */
    public static function isLoggedIn()
    {
        if (isset($_SESSION['user']) === true) {
            return true;
        } else {
            return false;
        }

    }//end isLoggedIn()


    /**
     * Regenerate the session ID
     * @return void
     */
    public static function regenerateID()
    {
        session_regenerate_id();

    }//end regenerateID()
}//end class
