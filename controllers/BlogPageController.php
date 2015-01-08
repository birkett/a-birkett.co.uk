<?php
//-----------------------------------------------------------------------------
// Build the blog pages
//      In: Unparsed template
//      Out: Parsed template
//
//  !!! This is a custom controller, only used for the Blog pages !!!
//-----------------------------------------------------------------------------
namespace ABirkett;

class BlogPageController extends BasePageController
{
    //-----------------------------------------------------------------------------
    // Fetch the specified post
    //		In: Post ID
    //		Out: Post data
    //-----------------------------------------------------------------------------
    private function getSinglePost($postid)
    {
        return GetDatabase()->runQuery(
            "SELECT * FROM blog_posts WHERE post_id = :id AND post_draft = '0'",
            array(":id" => $postid)
        );
    }

    //-----------------------------------------------------------------------------
    // Fetch a page of posts
    //		In: Page number
    //		Out: Post data
    //-----------------------------------------------------------------------------
    private function getMultiplePosts($page)
    {
        $limit1 = $page * BLOG_POSTS_PER_PAGE;
        $limit2 = BLOG_POSTS_PER_PAGE;
        return GetDatabase()->runQuery(
            "SELECT * FROM blog_posts WHERE post_draft = '0' ORDER BY post_timestamp DESC LIMIT $limit1,$limit2",
            array()
        );
    }

    //-----------------------------------------------------------------------------
    // Get the total number of blog posts
    //		In: none
    //		Out: Number of posts
    //-----------------------------------------------------------------------------
    private function getNumberOfPosts()
    {
        $count = GetDatabase()->runQuery("SELECT COUNT(*) from blog_posts", array());
        return $count[0]['COUNT(*)'];
    }

    //-----------------------------------------------------------------------------
    // Get the total comments on a specified post
    //		In: Post ID
    //		Out: Number of comments on specified post
    //-----------------------------------------------------------------------------
    private function getNumberOfComments($postid)
    {
        $count = GetDatabase()->runQuery(
            "SELECT COUNT(*) FROM blog_comments WHERE post_id = :postid",
            array(":postid" => $postid)
        );
        return $count[0]['COUNT(*)'];
    }

    //-----------------------------------------------------------------------------
    // Fetch the comments for specified post ID
    //		In: Post ID
    //		Out: All comments for post
    //-----------------------------------------------------------------------------
    private function getCommentsOnPost($postid)
    {
        return GetDatabase()->runQuery(
            "SELECT * FROM blog_comments WHERE post_id = :postid ORDER BY comment_timestamp ASC ",
            array(":postid" => $postid)
        );
    }

    //-----------------------------------------------------------------------------
    // Constructor
    //		In: Unparsed template
    //		Out: Parsed template
    //-----------------------------------------------------------------------------
    public function __construct(&$output)
    {
        $db = GetDatabase();
        $te = TemplateEngine();
        //Clamp pagniation offset
        if (
            isset($_GET['offset']) &&
            is_numeric($_GET['offset']) &&
            $_GET['offset'] >= 1 &&
            $_GET['offset'] < 100000
        ) {
            $offset = $_GET['offset'] - 1;
        } else {
            $offset = 0;
        }

        //Single post mode
        if (isset($_GET['postid']) && is_numeric($_GET['postid']) && $_GET['postid'] >= 0 && $_GET['postid'] < 500000) {
            $result = $this->getSinglePost($_GET['postid']);
            if ($db->GetNumRows($result) == 0) {
                header('Location: /404');  //Back out if we didnt find any posts
                return;
            }

            //Show comments
            $comments = $this->getCommentsOnPost($_GET['postid']);
            if ($db->GetNumRows($comments) != 0) {
                while (list($cid, $pid, $cusername, $ctext, $ctimestamp, $cip) = $db->GetRow($comments)) {
                    $tags = [
                        "{COMMENTAUTHOR}" => stripslashes($cusername),
                        "{COMMENTTIMESTAMP}" => date(DATE_FORMAT, $ctimestamp),
                        "{COMMENTCONTENT}" => stripslashes($ctext)
                    ];
                    $temp = $te->logicTag("{COMMENT}", "{/COMMENT}", $output);
                    $te->parseTags($tags, $temp);
                    $temp .= "{COMMENT}";
                    $te->replaceTag("{COMMENT}", $temp, $output); //Add this comment to the output
                }
            }

            //Snow new comments box
            $tags = [ "{COMMENTPOSTID}" => $_GET['postid'], "{RECAPTCHAKEY}" => RECAPTCHA_PUBLIC_KEY ];
            $te->parseTags($tags, $output);

            $te->removeLogicTag("{PAGINATION}", "{/PAGINATION}", $output); //No pagination in single post mode
        } else {
        //Normal mode
            $result = $this->getMultiplePosts($offset);
            if ($db->GetNumRows($result) == 0) {
                header('Location: /404'); //Back out if we didnt find any posts
                return;
            }

            //Show Pagination
            $numberofposts = $this->getNumberOfPosts();
            if ($numberofposts > BLOG_POSTS_PER_PAGE) {
                if ($offset > 0) {
                    $tags = [ "{PAGEPREVIOUSLINK}" => "/blog/page/$offset", "{PAGEPREVIOUSTEXT}" => "Previous Page" ];
                    $te->parseTags($tags, $output);
                }
                if (($offset + 1) * BLOG_POSTS_PER_PAGE < $numberofposts) {
                    $linkoffset = $offset + 2;
                    $tags = [ "{PAGENEXTLINK}" => "/blog/page/$linkoffset", "{PAGENEXTTEXT}" => "Next Page" ];
                    $te->parseTags($tags, $output);
                }
            } else {
                $te->removeLogicTag("{PAGINATION}", "{/PAGINATION}", $output); //Hide pagniation when too few posts
            }
            $te->removeLogicTag("{NEWCOMMENT}", "{/NEWCOMMENT}", $output); //No comments box in normal mode
        }

        //Rendering code
        while (list($id, $timestamp, $title, $content, $draft) = $db->GetRow($result)) {
            $tags = [
                "{POSTTIMESTAMP}" => date(DATE_FORMAT, $timestamp),
                "{POSTID}" => $id,
                "{POSTTITLE}" => $title,
                "{POSTCONTENT}" => stripslashes($content),
                "{COMMENTCOUNT}" => $this->getNumberOfComments($id)
            ];
            $temp = $te->logicTag("{BLOGPOST}", "{/BLOGPOST}", $output);
            $te->parseTags($tags, $temp);
            $temp .= "\n{BLOGPOST}";
            $te->replaceTag("{BLOGPOST}", $temp, $output); //Add this post to the output
        }

        $te->removeLogicTag("{BLOGPOST}", "{/BLOGPOST}", $output);
        $te->removeLogicTag("{COMMENT}", "{/COMMENT}", $output);

        //Clean up the tags if not already replaced
        $cleantags = [ "{PAGEPREVIOUSLINK}", "{PAGEPREVIOUSTEXT}", "{PAGENEXTLINK}", "{PAGENEXTTEXT}",
                        "{PAGINATION}", "{/PAGINATION}", "{NEWCOMMENT}", "{/NEWCOMMENT}" ];
        $te->removeTags($cleantags, $output);

        parent::__construct($output);
    }
}
