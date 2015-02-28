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
 * @category  Models
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
 * The method postComment() will take data from the controller and insert it
 * into the database.
 * getSinglePost() and checkIP() will both pass data to the controller.
 *
 * @category  Models
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */
class AJAXRequestModel extends BasePageModel
{


    /**
     * Post a new comment
     * @param integer $postid   ID of the post the comment is for.
     * @param string  $username Comment author.
     * @param string  $comment  Comment text.
     * @param string  $clientip IP address of the author.
     * @return boolean True on sucess, false on failiure
     */
    public function postComment($postid, $username, $comment, $clientip)
    {
        if ($this->isValidPostID($postid) !== true) {
            return false;
        }

        $this->database->runQuery(
            'INSERT INTO blog_comments('.
            'postID, commentUsername, commentText, commentTimestamp, '.
            'clientIP) VALUES(:pid, :uname, :cmnt, :time, :ip)',
            array(
             ':pid'   => $postid,
             ':uname' => $username,
             ':cmnt'  => $comment,
             ':time'  => time(),
             ':ip'    => $clientip,
            )
        );

        return true;

    }//end postComment()


    /**
     * Check if an IP address is blacklisted
     * @param  string $ipaddress IP address to check for.
     * @return boolean True if address is blacklisted, false otherwise
     */
    public function checkIP($ipaddress)
    {
        // Back out if filter_input failed.
        if ($ipaddress === null || $ipaddress === false) {
            return false;
        }

        $rows = $this->database->runQuery(
            'SELECT address from blocked_addresses WHERE address = :ip',
            array(':ip' => $ipaddress)
        );

        if ($this->database->getNumRows($rows) !== 0) {
            return true;
        }

        return false;

    }//end checkIP()


    /**
     * Check if a given postid matches a public post.
     * @param  integer $postid ID of the post to fetch.
     * @return boolean True if post exists, false if not
     */
    private function isValidPostID($postid)
    {
        $rows = $this->database->runQuery(
            "SELECT * FROM blog_posts WHERE postID = :id AND postDraft = '0'",
            array(':id' => $postid)
        );

        $result = $this->database->getNumRows($rows);

        if ($result !== 1) {
            return false;
        }

        return true;

    }//end isValidPostID()
}//end class
