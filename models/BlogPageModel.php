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
 * Handles data for the Blog. Glue between the database and controller.
 *
 * All of the functions here are used to get the various data and pass it back
 * to the controller. Because the BlogPageController can get a full page of
 * posts, or just single posts - this model is actually longer than anticipated.
 *
 * @category  Models
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */
class BlogPageModel extends BasePageModel
{


    /**
     * Get the post data and return it as an array
     * @param  integer $postid ID of the post to fetch.
     * @return array   Array of post data
     */
    public function getSinglePost($postid)
    {
        return $this->database->runQuery(
            'SELECT * FROM blog_posts WHERE postID = :id AND postDraft = "0"',
            array(':id' => $postid)
        );

    }//end getSinglePost()


    /**
     * Get posts data and return it as an array
     * @param  integer $page Page number to fetch.
     * @return array   Array of posts data
     */
    public function getMultiplePosts($page)
    {
        return $this->database->runQuery(
            'SELECT * FROM blog_posts WHERE postDraft = "0"'.
            ' ORDER BY postTimestamp DESC LIMIT '.
            ($page * BLOG_POSTS_PER_PAGE).','.BLOG_POSTS_PER_PAGE,
            array()
        );

    }//end getMultiplePosts()


    /**
     * Get the total number of public blog posts
     * @return integer Total number of blog posts
     */
    public function getNumberOfPosts()
    {
        $rows = $this->database->runQuery(
            'SELECT postID from blog_posts WHERE postDraft = "0"',
            array()
        );

        $count = $this->database->getNumRows($rows);

        return $count;

    }//end getNumberOfPosts()


    /**
     * Get the total number of comments on a post
     * @param  integer $postid ID of the post to count comments on.
     * @return integer Total number of comments on post
     */
    public function getNumberOfComments($postid)
    {
        $rows = $this->database->runQuery(
            'SELECT commentID FROM blog_comments WHERE postID = :postid',
            array(':postid' => $postid)
        );

        $count = $this->database->getNumRows($rows);

        return $count;

    }//end getNumberOfComments()


    /**
     * Get the comments for a specified post
     * @param  integer $postid ID of the post to fetch comments for.
     * @return array   array of comments data
     */
    public function getCommentsOnPost($postid)
    {
        return $this->database->runQuery(
            'SELECT commentUsername, commentText, commentTimestamp'.
            ' FROM blog_comments WHERE postID = :pid'.
            ' ORDER BY commentTimestamp ASC',
            array(':pid' => $postid)
        );

    }//end getCommentsOnPost()
}//end class
