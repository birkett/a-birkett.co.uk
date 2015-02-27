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
 * PHP Version 5.5
 *
 * @category  AdminModels
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\models;

/**
 * Handles data for AJAX requests. Glue between the database and controller.
 *
 * All of the functions here should be treated as dangerous.
 *
 * @category  AdminModels
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */
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
        if ($title === '' || $content === '' || $draft === '') {
            return false;
        }

        $this->database->runQuery(
            'INSERT INTO blog_posts('.
            'postTimestamp, postTitle, postContent, postDraft, postTweeted'.
            ') VALUES(:timestamp, :title, :content, :draft, 0)',
            array(
             ':timestamp' => time(),
             ':title'     => $title,
             ':content'   => $content,
             ':draft'     => ($draft === 'true') ? 1 : 0,
            )
        );
        $postid = $this->database->lastInsertedID();
        // Tweet this.
        $this->tweetPost($postid);

        return $postid;

    }//end newPost()


    /**
     * Update a post
     * @param integer $postid ID of the post to update.
     * @param string  $title  Title of the post.
     * @param string  $cont   Body text of the post.
     * @param boolean $draft  Is the post public.
     * @return boolean True on success, false on failiure
     */
    public function updatePost($postid, $title, $cont, $draft)
    {
        if ($postid === '' || $title === '' || $cont === '' || $draft === '') {
            return false;
        }

        $this->database->runQuery(
            'UPDATE blog_posts SET postTitle = :ti, postContent = :txt, '.
            'postDraft = :draft WHERE postID = :pid LIMIT 1',
            array(
             ':ti'    => $title,
             ':txt'   => $cont,
             ':draft' => ($draft === 'true') ? 1 : 0,
             ':pid'   => $postid,
            )
        );

        // Tweet about this post if its status has changed from draft.
        $this->tweetPost($postid);

        return true;

    }//end updatePost()


    /**
     * Update a page
     * @param  integer $pageid  ID of the page to update.
     * @param  string  $content Body text of the page.
     * @return boolean True on success, false on failiure
     */
    public function updatePage($pageid, $content)
    {
        if ($pageid === '' || $content === '') {
            return false;
        }

        $this->database->runQuery(
            'UPDATE site_pages SET pageContent = :cont WHERE pageID = :pid',
            array(
             ':cont' => $content,
             ':pid'  => $pageid,
            )
        );

        return true;

    }//end updatePage()


    /**
     * Add an IP address to the blacklist
     * @param  string $ipaddress IP address to block.
     * @return boolean True on success, false on failiure
     */
    public function blockIP($ipaddress)
    {
        if ($ipaddress === '') {
            return false;
        }

        // Do nothing if already blocked.
        if (parent::checkIP($ipaddress) === true) {
            return true;
        }

        $this->database->runQuery(
            'INSERT INTO blocked_addresses(address, timestamp)'.
            ' VALUES(:ip, :timestamp)',
            array(
             ':ip'        => $ipaddress,
             ':timestamp' => time(),
            )
        );

        return true;

    }//end blockIP()


    /**
     * Remove an IP address from the blacklist
     * @param  string $ipaddress IP address to be unblocked.
     * @return boolean True on success, false on failiure
     */
    public function unblockIP($ipaddress)
    {
        if ($ipaddress === '') {
            return false;
        }

        $this->database->runQuery(
            'DELETE FROM blocked_addresses WHERE address = :ip',
            array(':ip' => $ipaddress)
        );

        return true;

    }//end unblockIP()


    /**
     * Change a user password
     * @param  string $user       Username.
     * @param  string $currentp   Current user password.
     * @param  string $newp       Intended new password.
     * @param  string $confirmedp Verification of the new password.
     * @return boolean True on updated, False on error
     */
    public function changePassword($user, $currentp, $newp, $confirmedp)
    {
        if ($user === ''
            || $currentp === ''
            || $newp === ''
            || $confirmedp === ''
        ) {
            return false;
        }

        // Passwords dont match.
        if ($newp !== $confirmedp) {
            return false;
        }

        // Current password is wrong.
        if ($this->checkCredentials($user, $currentp) === false) {
            return false;
        }

        $hash = $this->hashPassword($newp);

        $this->database->runQuery(
            'UPDATE site_users SET password = :hash WHERE username = :user',
            array(
             ':hash' => $hash,
             ':user'  => $user,
            )
        );

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
        if ($username === '' || $password === '') {
            return false;
        }

        $result = $this->database->runQuery(
            'SELECT password FROM site_users WHERE username = :username',
            array(':username' => $username)
        );

        if ($this->database->getNumRows($result) === 1) {
            $dbhash = $this->database->getRow($result);

            // Password_verify is PHP 5.5+.
            if (password_verify($password, $dbhash->password) === true) {
                return true;
            }
        }//end if

        return false;

    }//end checkCredentials()


    /**
     * Get the post data and return it as an array
     * @param  integer $postid ID of the post to fetch.
     * @return array Array of post data
     */
    private function getSinglePost($postid)
    {
        $rows = $this->database->runQuery(
            "SELECT * FROM blog_posts WHERE postID = :id AND postDraft = '0'",
            array(':id' => $postid)
        );

        return $rows;

    }//end getSinglePost()


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
        $post = $this->getSinglePost($postid);
        if ($this->database->getNumRows($post) === 0) {
            return;
        }

        // Already tweeted out.
        $row = $this->database->getRow($post);
        if ($row->postTweeted === '1') {
            return;
        }

        $url = parent::getBaseURL().'blog/'.$row->postID;

        $tweet = 'New Blog Post: '.$row->postTitle.' - '.$url;

        $twitter = new \ABirkett\classes\TwitterOAuth();
        $twitter->oAuthRequest(
            'statuses/update',
            'POST',
            array('status' => $tweet)
        );

        $this->database->runQuery(
            'UPDATE blog_posts SET postTweeted=1 WHERE postID = :postid',
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
        // Password_hash is PHP 5.5+.
        return password_hash($password, PASSWORD_BCRYPT, $options);

    }//end hashPassword()
}//end class
