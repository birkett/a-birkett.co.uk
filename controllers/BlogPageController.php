<?php
/**
 * BlogPageController - pull data from the model to populate the template
 *
 * PHP Version 5.5
 *
 * @category  Controllers
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\controllers;

class BlogPageController extends BasePageController
{


    /**
     * Build the blog page
     * @param string $output Unparsed template passed by reference.
     * @return none
     */
    public function __construct(&$output)
    {
        parent::__construct($output);
        $this->model = new \ABirkett\models\BlogPageModel();
        // Clamp pagniation offset.
        if (isset($_GET['offset']) === true
            && is_numeric($_GET['offset'])
            && $_GET['offset'] >= 1
            && $_GET['offset'] < 100000
        ) {
            $offset = $_GET['offset'] - 1;
        } else {
            $offset = 0;
        }

        // Single post mode.
        if (isset($_GET['postid']) === true
            && is_numeric($_GET['postid'])
            && $_GET['postid'] >= 0
            && $_GET['postid'] < 500000
            ) {
            $result = $this->model->getSinglePost($_GET['postid']);
            // Back out if we didnt find any posts.
            if ($this->model->database->GetNumRows($result) == 0) {
                header('Location: /404');
                return;
            }

            // Show comments.
            $comments = $this->model->getCommentsOnPost($_GET['postid']);
            if ($this->model->database->GetNumRows($comments) != 0) {
                while ($comment = $this->model->database->GetRow($comments)) {
                    $tags = array(
                        '{COMMENTAUTHOR}' =>
                            stripslashes($comment['comment_username']),
                        '{COMMENTTIMESTAMP}' =>
                            date(DATE_FORMAT, $comment['comment_timestamp']),
                        '{COMMENTCONTENT}' =>
                            stripslashes($comment['comment_text'])
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
                }
            }

            // Snow new comments box.
            $tags = array(
                '{COMMENTPOSTID}' => $_GET['postid'],
                '{RECAPTCHAKEY}' => RECAPTCHA_PUBLIC_KEY
            );
            $this->templateEngine->parseTags($tags, $output);
            // No pagination.
            $this->templateEngine->removeLogicTag(
                '{PAGINATION}',
                '{/PAGINATION}',
                $output
            );
        } else {
            // Normal mode.
            $result = $this->model->getMultiplePosts($offset);
            // Back out if we didnt find any posts.
            if ($this->model->database->GetNumRows($result) == 0) {
                header('Location: /404');
                return;
            }

            // Show Pagination.
            $numberofposts = $this->model->getNumberOfPosts();
            if ($numberofposts > BLOG_POSTS_PER_PAGE) {
                if ($offset > 0) {
                    $tags = array(
                        '{PAGEPREVIOUSLINK}' => "/blog/page/$offset",
                        '{PAGEPREVIOUSTEXT}' => 'Previous Page'
                    );
                    $this->templateEngine->parseTags($tags, $output);
                }
                if (($offset + 1) * BLOG_POSTS_PER_PAGE < $numberofposts) {
                    $linkoffset = $offset + 2;
                    $tags = [
                        '{PAGENEXTLINK}' => "/blog/page/$linkoffset",
                        '{PAGENEXTTEXT}' => 'Next Page'
                    ];
                    $this->templateEngine->parseTags($tags, $output);
                }
            } else {
                // Hide pagniation.
                $this->templateEngine->removeLogicTag(
                    '{PAGINATION}',
                    '{/PAGINATION}',
                    $output
                );
            }
            // Hide new comment box.
            $this->templateEngine->removeLogicTag(
                '{NEWCOMMENT}',
                '{/NEWCOMMENT}',
                $output
            );
        }

        // Rendering code.
        while ($post = $this->model->database->GetRow($result)) {
            $tags = array(
                '{POSTTIMESTAMP}' =>
                    date(DATE_FORMAT, $post['post_timestamp']),
                '{POSTID}' =>
                    $post['post_id'],
                '{POSTTITLE}' =>
                    $post['post_title'],
                '{POSTCONTENT}' =>
                    stripslashes($post['post_content']),
                '{COMMENTCOUNT}' =>
                    $this->model->getNumberOfComments($post['post_id'])
            );
            $temp = $this->templateEngine->logicTag(
                '{BLOGPOST}',
                '{/BLOGPOST}',
                $output
            );
            $this->templateEngine->parseTags($tags, $temp);
            $temp .= "\n{BLOGPOST}";
            $this->templateEngine->replaceTag('{BLOGPOST}', $temp, $output);
        }

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

        //Clean up the tags if not already replaced
        $cleantags = array(
            '{PAGEPREVIOUSLINK}',
            '{PAGEPREVIOUSTEXT}',
            '{PAGENEXTLINK}',
            '{PAGENEXTTEXT}',
            '{PAGINATION}',
            '{/PAGINATION}',
            '{NEWCOMMENT}',
            '{/NEWCOMMENT}'
        );
        $this->templateEngine->removeTags($cleantags, $output);

    }//end __construct()
}//end class
