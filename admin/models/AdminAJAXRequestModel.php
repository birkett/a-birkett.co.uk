<?php
/**
 * AdminAJAXRequestModel - glue between the database and Controller
 *
 * PHP Version 5.3
 *
 * @category  AdminModels
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\models;

class AdminAJAXRequestModel extends AJAXRequestModel
{


    /**
     * Add a new post
     * @param string  $title   Title of the new post.
     * @param string  $content Body text of the post.
     * @param boolean $draft   Is the post public yet.
     * @return void
     */
    public function newPost($title, $content, $draft)
    {
        $this->database->runQuery(
            'INSERT INTO blog_posts('.
            'post_timestamp,post_title,post_content,post_draft,post_tweeted'.
            ') VALUES(:timestamp, :title, :content, :draft, 0)',
            array(
             ':timestamp' => time(),
             ':title'     => $title,
             ':content'   => $content,
             ':draft'     => ($draft === 'true') ? 1 : 0,
            )
        );
        $id = $this->database->lastInsertedID();
        // Tweet this.
        $this->tweetPost($id);

    }//end newPost()


    /**
     * Update a post
     * @param integer $postid  ID of the post to update.
     * @param string  $title   Title of the post.
     * @param string  $content Body text of the post.
     * @param boolean $draft   Is the post public.
     * @return void
     */
    public function updatePost($postid, $title, $content, $draft)
    {
        $this->database->runQuery(
            'UPDATE blog_posts SET post_title = :ti, post_content = :txt, '.
            'post_draft = :draft WHERE post_id = :pid LIMIT 1',
            array(
             ':ti'    => $title,
             ':txt'   => $content,
             ':draft' => ($draft === 'true') ? 1 : 0,
             ':pid'   => $postid,
            )
        );
        $this->tweetPost($postid);

    }//end updatePost()


    /**
     * Update a page
     * @param  integer $pageid  ID of the page to update.
     * @param  string  $content Body text of the page.
     * @return void
     */
    public function updatePage($pageid, $content)
    {
        $this->database->runQuery(
            'UPDATE site_pages SET page_content = :cont WHERE page_id = :pid',
            array(
             ':cont' => $content,
             ':pid'  => $pageid,
            )
        );

    }//end updatePage()


    /**
     * Add an IP address to the blacklist
     * @param  string $ip IP address to block.
     * @return void
     */
    public function blockIP($ip)
    {
        // Do nothing if already blocked.
        if (parent::checkIP($ip) !== '0') {
            return;
        }

        $this->database->runQuery(
            'INSERT INTO blocked_addresses(address, blocked_timestamp)'.
            ' VALUES(:ip, :timestamp)',
            array(
             ':ip'        => $ip,
             ':timestamp' => time()
            )
        );

    }//end blockIP()


    /**
     * Remove an IP address from the blacklist
     * @param  string $ip IP address to be unblocked.
     * @return void
     */
    public function unblockIP($ip)
    {
        $this->database->runQuery(
            'DELETE FROM blocked_addresses WHERE address = :ip',
            array(':ip' => $ip)
        );

    }//end unblockIP()


    /**
     * Change a user password
     * @param  string $currentp   Current user password.
     * @param  string $newp       Intended new password.
     * @param  string $confirmedp Verification of the new password.
     * @return boolean True on updated, False on error
     */
    public function changePassword($currentp, $newp, $confirmedp)
    {
        // Passwords dont match.
        if ($newp !== $confirmedp) {
            return false;
        }

        $data = $this->database->runQuery(
            'SELECT username FROM site_users WHERE user_id=:uid',
            array(':uid' => 1)
        );

        $row = $this->database->getRow($data);

        // Current password is wrong.
        if ($this->checkCredentials($row['username'], $currentp) === false) {
            return false;
        }

        $hash = $this->hashPassword($newp);

        $this->database->runQuery(
            "UPDATE site_users SET password='$hash' WHERE user_id=:uid",
            array(':uid' => 1)
        );

        // Regenerate the session ID when changing password.
        \ABirkett\classes\SessionManager::regenerateID();
        return true;

    }//end changePassword()


    /**
     * Check if supplied credentials match the database (login function)
     * @param  string $username Input username.
     * @param  string $password Input password.
     * @return boolean True when verified, False otherwise
     */
    public function checkCredentials($username, $password)
    {
        $result = $this->database->runQuery(
            'SELECT password FROM site_users WHERE username = :username',
            array(':username' => $username)
        );

        if ($this->database->getNumRows($result) === 1) {
            $dbhash = $this->database->getRow($result);

            // Password_verify is PHP 5.5+, fall back on older versions.
            if (function_exists('password_verify') === true) {
                $check = password_verify($password, $dbhash['password']);
            } else {
                $hash = $this->hashPassword($password);
                if ($hash === $dbhash['password']) {
                    $check = true;
                } else {
                    $check = false;
                }
            }

            if ($check === true) {
                return true;
            }
        }//end if

        return false;

    }//end checkCredentials()


    /**
     * Send a tweet about a new post
     * @param  integer $postid Id of the post to be tweeted.
     * @return void
     */
    public function tweetPost($postid)
    {
        // Post ID not set, maybe newPost() failed.
        if (isset($postid) === false) {
            return;
        }

        // Post doesnt exist or is a draft.
        $post = parent::getSinglePost($postid);
        if ($this->database->getNumRows($post) === 0) {
            return;
        }

        // Already tweeted out.
        $row = $this->database->getRow($post);
        if ($row['post_tweeted'] === '1') {
            return;
        }

        $url = parent::getBaseURL().'blog/'.$row['post_id'];

        $tweet = 'New Blog Post: '.$row['post_title'].' - '.$url;

        $twitter = new \ABirkett\classes\TwitterOAuth();
        $twitter->oAuthRequest(
            'statuses/update',
            'POST',
            array('status' => $tweet)
        );

        $this->database->runQuery(
            'UPDATE blog_posts SET post_tweeted=1 WHERE post_id = :postid',
            array(':postid' => $postid)
        );

    }//end tweetPost()


    /**
     * Generate a new password hash using a random salt
     * @param  string $password Plain text password.
     * @return string Password hash
     */
    public function hashPassword($password)
    {
        $options = array('cost' => HASHING_COST);
        // Password_hash is PHP 5.5+, fall back when not available.
        if (function_exists('password_hash') === true) {
            return password_hash($password, PASSWORD_BCRYPT, $options);
        } else {
            $salt = base64_encode(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));
            $salt = str_replace('+', '.', $salt);
            return crypt($password, '$2y$'.$options['cost'].'$'.$salt.'$');
        }

    }//end hashPassword()
}//end class
