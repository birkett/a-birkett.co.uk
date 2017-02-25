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
 * @category  Controllers
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\controllers;

use ABFramework\controllers\BasePageController;
use ABirkett\models\BlogPageModel;
use ABirkett\classes\Recaptcha;

/**
 * Handles generating the Blog pages.
 *
 * The logic here will generate a page of posts or a single post, and will
 * accept a page / post id as input.
 * This also handles displaying the pagination, comments and new comments box.
 *
 * Some of the logic here is too long, and should really be broken up.
 *
 * @category  Controllers
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */
class BlogPageController extends BasePageController
{


    /**
     * Build the blog page.
     * @return none
     */
    public function __construct()
    {
        parent::__construct();
        $this->model = new BlogPageModel();
    }//end __construct()


    /**
     * Build the blog page, handle GET requests.
     * @param string $output Unparsed template passed by reference.
     * @return none
     */
    public function getHandler(&$output)
    {
        parent::getHandler($output);
        $this->model = new \ABirkett\models\BlogPageModel();

        $offset = $this->model->getGetVar('offset', FILTER_SANITIZE_NUMBER_INT);
        $postid = $this->model->getGetVar('postid', FILTER_SANITIZE_NUMBER_INT);

        // Default to multiple view when nothing specified.
        if (isset($offset) === false && isset($postid) === false) {
            $offset = 1;
        }

        // Single post mode.
        if (isset($postid) === true) {
            $result = $this->model->getSinglePost($postid);
            // Back out if we didnt find any posts.
            if ($result === null) {
                header('Location: /404');

                return;
            }

            // No pagination.
            $this->removePagination($output);
            // Show new comments box.
            $this->renderNewCommentBox($postid, $output);
            // Show comments.
            $this->renderComments($postid, $output);
        }//end if

        // Page fetch mode. Only do this if postid not specified, just incase
        // someone plays with the URL to request a post and page.
        if (isset($offset) === true && isset($postid) === false) {
            // Page 0 should be the same as page 1.
            if (intval($offset) <= 0) {
                $offset = 1;
            }

            $result = $this->model->getMultiplePosts($offset - 1);
            // Back out if we didnt find any posts.
            if ($result === null) {
                header('Location: /404');

                return;
            }

            // Hide new comment box.
            $this->removeNewCommentBox($output);
            // Pagination.
            $this->renderPagination($offset, $output);
        }//end if

        // Rendering code.
        $this->renderPosts($result, $output);
        $this->cleanupTags($output);

    }//end getHandler()


    /**
     * Build the blog page, handle POST requests.
     * @param string $output Unparsed template passed by reference.
     * @return none
     */
    public function postHandler(&$output)
    {
        // Basic.
        $mode = $this->model->getPostVar('mode', FILTER_SANITIZE_STRING);
        // Used for comments.
        $post = $this->model->getPostVar('postid', FILTER_SANITIZE_NUMBER_INT);
        $user = $this->model->getPostVar('username', FILTER_SANITIZE_STRING);
        $comm = $this->model->getPostVar('comment', FILTER_SANITIZE_STRING);
        $resp = $this->model->getPostVar('response', FILTER_SANITIZE_STRING);
        $cip  = $this->model->getServerVar('REMOTE_ADDR', FILTER_VALIDATE_IP);

        if ($mode === 'postcomment') {
            if (isset($user) === false
                || isset($comm) === false
                || $resp === ''
            ) {
                $this->badRequest('Please fill out all details.');
                return;
            }

            if ($this->strClamp($user, 3, 25) !== true) {
                $this->badRequest('Username should be 3 - 25 characters');
                return;
            }

            if ($this->strClamp($comm, 10, 1000) !== true) {
                $this->badRequest('Comment should be 10 - 1000 characters');
                return;
            }

            if ($this->model->checkIP($cip) !== false) {
                $this->badRequest('Your address is blocked.');
                return;
            }

            $recaptcha = new Recaptcha(
                RECAPTHCA_PRIVATE_KEY,
                $cip,
                $resp
            );

            if ($recaptcha->response->success !== true) {
                $this->badRequest('Captcha verification failed');
                return;
            }

            if ($this->model->postComment($post, $user, $comm, $cip) !== true) {
                $this->badRequest('Something was rejected.');
                return;
            }

            $this->goodRequest('Comment Posted!');
        }//end if
    }//end postHandler()


    /**
     * Render comments to the output
     * @param integer $postid Post ID for which to pull comments for.
     * @param string  $output Page to render to.
     * @return void
     */
    private function renderComments($postid, &$output)
    {
        $comments = $this->model->getCommentsOnPost($postid);
        // No needs to check if $comments is empty, foreach is smart enough.
        foreach ($comments as $comment) {
            $date = date(DATE_FORMAT, $comment->commentTimestamp);
            $tags = array(
                     '{COMMENTAUTHOR}'    => $comment->commentUsername,
                     '{COMMENTTIMESTAMP}' => $date,
                     '{COMMENTCONTENT}'   => $comment->commentText,
                    );
            $temp = $this->templateEngine->logicTag(
                '{COMMENT}',
                '{/COMMENT}',
                $output
            );
            $this->templateEngine->parseTags($tags, $temp);
            // Add this comment to the output.
            $temp .= '{COMMENT}';
            $this->templateEngine->replaceTag(
                '{COMMENT}',
                $temp,
                $output
            );
        }//end foreach

    }//end renderComments()


    /**
     * Render posts to the output
     * @param array  $posts  Array of posts to render.
     * @param string $output Page to render to.
     * @return void
     */
    private function renderPosts(array $posts, &$output)
    {
        foreach ($posts as $post) {
            $date = date(DATE_FORMAT, $post->postTimestamp);
            $numc = $this->model->getNumberOfComments($post->postID);
            $tags = array(
                     '{POSTTIMESTAMP}' => $date,
                     '{POSTID}'        => $post->postID,
                     '{POSTTITLE}'     => $post->postTitle,
                     '{POSTCONTENT}'   => stripslashes($post->postContent),
                     '{COMMENTCOUNT}'  => $numc,
                    );
            $temp = $this->templateEngine->logicTag(
                '{BLOGPOST}',
                '{/BLOGPOST}',
                $output
            );
            $this->templateEngine->parseTags($tags, $temp);
            $temp .= "\n{BLOGPOST}";
            $this->templateEngine->replaceTag('{BLOGPOST}', $temp, $output);
        }//end foreach

    }//end renderPosts()


    /**
     * Render the new comment box to the output
     * @param integer $postid Post ID for which to post comments for.
     * @param string  $output Page to render to.
     * @return void
     */
    private function renderNewCommentBox($postid, &$output)
    {
        $tags = array(
                 '{COMMENTPOSTID}' => $postid,
                 '{RECAPTCHAKEY}'  => RECAPTCHA_PUBLIC_KEY,
                );
        $this->templateEngine->parseTags($tags, $output);

    }//end renderNewCommentBox()


    /**
     * Remove the new comment box from the output
     * @param string $output Page to render to.
     * @return void
     */
    private function removeNewCommentBox(&$output)
    {
        $this->templateEngine->removeLogicTag(
            '{NEWCOMMENT}',
            '{/NEWCOMMENT}',
            $output
        );

    }//end removeNewCommentBox()


    /**
     * Render the pagination to the output
     * @param integer $offset Page offset to calculate next and previous links.
     * @param string  $output Page to render to.
     * @return void
     */
    private function renderPagination($offset, &$output)
    {
        // Render the previous page link when needed.
        if ($offset > 1) {
            $tags = array(
                     '{PAGEPREVLINK}' => '/blog/page/'.($offset - 1),
                     '{PAGEPREVTEXT}' => 'Previous Page',
                    );
            $this->templateEngine->parseTags($tags, $output);
        }

        // Render the next page link.
        $numberofposts = $this->model->getNumberOfPosts();

        if (($offset * BLOG_POSTS_PER_PAGE) < $numberofposts) {
            $tags = array(
                     '{PAGENEXTLINK}' => '/blog/page/'.($offset + 1),
                     '{PAGENEXTTEXT}' => 'Next Page',
                    );
            $this->templateEngine->parseTags($tags, $output);
        }

        // Hide pagniation when not enough posts in the blog.
        if ($numberofposts < BLOG_POSTS_PER_PAGE) {
            $this->removePagination($output);
        }

    }//end renderPagination()


    /**
     * Remove the pagination from the output
     * @param string $output Page to render to.
     * @return void
     */
    private function removePagination(&$output)
    {
        $this->templateEngine->removeLogicTag(
            '{PAGINATION}',
            '{/PAGINATION}',
            $output
        );

    }//end removePagination()


    /**
     * Remove unused tags from the page
     * @param string $output Page to render to.
     * @return void
     */
    private function cleanupTags(&$output)
    {
        $this->templateEngine->removeLogicTag(
            '{BLOGPOST}',
            '{/BLOGPOST}',
            $output
        );
        $this->templateEngine->removeLogicTag(
            '{COMMENT}',
            '{/COMMENT}',
            $output
        );

        // Clean up the tags if not already replaced.
        $cleantags = array(
                      '{PAGEPREVLINK}',
                      '{PAGEPREVTEXT}',
                      '{PAGENEXTLINK}',
                      '{PAGENEXTTEXT}',
                      '{PAGINATION}',
                      '{/PAGINATION}',
                      '{NEWCOMMENT}',
                      '{/NEWCOMMENT}',
                     );
        $this->templateEngine->removeTags($cleantags, $output);

    }//end cleanupTags()
}//end class
