<?php
/**
* BlogPageController - pull data from the model to populate the template
*
* PHP Version 5.5
*
* @category Controllers
* @package  PersonalWebsite
* @author   Anthony Birkett <anthony@a-birkett.co.uk>
* @license  http://opensource.org/licenses/MIT MIT
* @link     http://www.a-birkett.co.uk
*/
namespace ABirkett\controllers;

class BlogPageController extends BasePageController
{
    /**
    * Build the blog page
    * @param string $output Unparsed template passed by reference
    * @return none
    */
    public function __construct(&$output)
    {
        parent::__construct($output);
        $this->model = new \ABirkett\models\BlogPageModel();
        //Clamp pagniation offset
        if (isset($_GET['offset'])
            && is_numeric($_GET['offset'])
            && $_GET['offset'] >= 1
            && $_GET['offset'] < 100000
        ) {
            $offset = $_GET['offset'] - 1;
        } else {
            $offset = 0;
        }

        //Single post mode
        if (isset($_GET['postid'])
            && is_numeric($_GET['postid'])
            && $_GET['postid'] >= 0
            && $_GET['postid'] < 500000
            ) {
            $result = $this->model->getSinglePost($_GET['postid']);
            if ($this->model->database->GetNumRows($result) == 0) {
                header('Location: /404');  //Back out if we didnt find any posts
                return;
            }

            //Show comments
            $comments = $this->model->getCommentsOnPost($_GET['postid']);
            if ($this->model->database->GetNumRows($comments) != 0) {
                while (list($cusername, $ctext, $ctimestamp) = $this->model->database->GetRow($comments)) {
                    $tags = [
                        "{COMMENTAUTHOR}" => stripslashes($cusername),
                        "{COMMENTTIMESTAMP}" => date(DATE_FORMAT, $ctimestamp),
                        "{COMMENTCONTENT}" => stripslashes($ctext)
                    ];
                    $temp = $this->templateEngine->logicTag(
                        "{COMMENT}",
                        "{/COMMENT}",
                        $output
                    );
                    $this->templateEngine->parseTags($tags, $temp);
                    $temp .= "{COMMENT}";
                    $this->templateEngine->replaceTag(
                        "{COMMENT}",
                        $temp,
                        $output
                    ); //Add this comment to the output
                }
            }

            //Snow new comments box
            $tags = [
                "{COMMENTPOSTID}" => $_GET['postid'],
                "{RECAPTCHAKEY}" => RECAPTCHA_PUBLIC_KEY
            ];
            $this->templateEngine->parseTags($tags, $output);
            $this->templateEngine->removeLogicTag(
                "{PAGINATION}",
                "{/PAGINATION}",
                $output
            ); //No pagination
        } else {
            //Normal mode
            $result = $this->model->getMultiplePosts($offset);
            if ($this->model->database->GetNumRows($result) == 0) {
                header('Location: /404'); //Back out if we didnt find any posts
                return;
            }

            //Show Pagination
            $numberofposts = $this->model->getNumberOfPosts();
            if ($numberofposts > BLOG_POSTS_PER_PAGE) {
                if ($offset > 0) {
                    $tags = [
                        "{PAGEPREVIOUSLINK}" => "/blog/page/$offset",
                        "{PAGEPREVIOUSTEXT}" => "Previous Page"
                    ];
                    $this->templateEngine->parseTags($tags, $output);
                }
                if (($offset + 1) * BLOG_POSTS_PER_PAGE < $numberofposts) {
                    $linkoffset = $offset + 2;
                    $tags = [
                        "{PAGENEXTLINK}" => "/blog/page/$linkoffset",
                        "{PAGENEXTTEXT}" => "Next Page"
                    ];
                    $this->templateEngine->parseTags($tags, $output);
                }
            } else {
                $this->templateEngine->removeLogicTag(
                    "{PAGINATION}",
                    "{/PAGINATION}",
                    $output
                ); //Hide pagniation
            }
            $this->templateEngine->removeLogicTag(
                "{NEWCOMMENT}",
                "{/NEWCOMMENT}",
                $output
            ); //Hide new comment box
        }

        //Rendering code
        while (list($id, $timestamp, $title, $content, $draft) = $this->model->database->GetRow($result)) {
            $tags = [
                "{POSTTIMESTAMP}" => date(DATE_FORMAT, $timestamp),
                "{POSTID}" => $id,
                "{POSTTITLE}" => $title,
                "{POSTCONTENT}" => stripslashes($content),
                "{COMMENTCOUNT}" => $this->model->getNumberOfComments($id)
            ];
            $temp = $this->templateEngine->logicTag(
                "{BLOGPOST}",
                "{/BLOGPOST}",
                $output
            );
            $this->templateEngine->parseTags($tags, $temp);
            $temp .= "\n{BLOGPOST}";
            $this->templateEngine->replaceTag("{BLOGPOST}", $temp, $output);
        }

        $this->templateEngine->removeLogicTag(
            "{BLOGPOST}",
            "{/BLOGPOST}",
            $output
        );
        $this->templateEngine->removeLogicTag(
            "{COMMENT}",
            "{/COMMENT}",
            $output
        );

        //Clean up the tags if not already replaced
        $cleantags = [
            "{PAGEPREVIOUSLINK}",
            "{PAGEPREVIOUSTEXT}",
            "{PAGENEXTLINK}",
            "{PAGENEXTTEXT}",
            "{PAGINATION}",
            "{/PAGINATION}",
            "{NEWCOMMENT}",
            "{/NEWCOMMENT}"
        ];
        $this->templateEngine->removeTags($cleantags, $output);
    }
}
