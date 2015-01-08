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
    // Get the total number of blog posts
    //		In: none
    //		Out: Number of posts
    //-----------------------------------------------------------------------------
    function GetNumberOfPosts()
    {
        $count = GetDatabase()->runQuery("SELECT COUNT(*) from blog_posts", array());
        return $count[0]['COUNT(*)'];
    }

    //-----------------------------------------------------------------------------
    // Get the total comments on a specified post
    //		In: Post ID
    //		Out: Number of comments on specified post
    //-----------------------------------------------------------------------------
    function GetNumberOfComments($postid)
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
    function GetCommentsOnPost($postid)
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
            $result = GetPosts("single", $_GET['postid'], false);
            if ($db->GetNumRows($result) == 0) {
                header('Location: /404');  //Back out if we didnt find any posts
                return;
            }

            //Show comments
            $comments = $this->GetCommentsOnPost($_GET['postid']);
            if ($db->GetNumRows($comments) != 0) {
                while (list($cid, $pid, $cusername, $ctext, $ctimestamp, $cip) = $db->GetRow($comments)) {
                    $tags = [
                        "{COMMENTAUTHOR}" => stripslashes($cusername),
                        "{COMMENTTIMESTAMP}" => date(DATE_FORMAT, $ctimestamp),
                        "{COMMENTCONTENT}" => stripslashes($ctext)
                    ];
                    $temp = LogicTag("{COMMENT}", "{/COMMENT}", $output);
                    ParseTags($tags, $temp);
                    $temp .= "{COMMENT}";
                    ReplaceTag("{COMMENT}", $temp, $output); //Add this comment to the output
                }
            }

            //Snow new comments box
            $tags = [ "{COMMENTPOSTID}" => $_GET['postid'], "{RECAPTCHAKEY}" => RECAPTCHA_PUBLIC_KEY ];
            ParseTags($tags, $output);

            RemoveLogicTag("{PAGINATION}", "{/PAGINATION}", $output); //No pagination in single post mode
        } else {
        //Normal mode
            $result = GetPosts("page", $offset, false);
            if ($db->GetNumRows($result) == 0) {
                header('Location: /404'); //Back out if we didnt find any posts
                return;
            }

            //Show Pagination
            $numberofposts = $this->GetNumberOfPosts();
            if ($numberofposts > BLOG_POSTS_PER_PAGE) {
                if ($offset > 0) {
                    $tags = [ "{PAGEPREVIOUSLINK}" => "/blog/page/$offset", "{PAGEPREVIOUSTEXT}" => "Previous Page" ];
                    ParseTags($tags, $output);
                }
                if (($offset + 1) * BLOG_POSTS_PER_PAGE < $numberofposts) {
                    $linkoffset = $offset + 2;
                    $tags = [ "{PAGENEXTLINK}" => "/blog/page/$linkoffset", "{PAGENEXTTEXT}" => "Next Page" ];
                    ParseTags($tags, $output);
                }
            } else {
                RemoveLogicTag("{PAGINATION}", "{/PAGINATION}", $output); //Hide pagniation when too few posts
            }
            RemoveLogicTag("{NEWCOMMENT}", "{/NEWCOMMENT}", $output); //No comments box in normal mode
        }

        //Rendering code
        while (list($id, $timestamp, $title, $content, $draft) = $db->GetRow($result)) {
            $tags = [
                "{POSTTIMESTAMP}" => date(DATE_FORMAT, $timestamp),
                "{POSTID}" => $id,
                "{POSTTITLE}" => $title,
                "{POSTCONTENT}" => stripslashes($content),
                "{COMMENTCOUNT}" => $this->GetNumberOfComments($id)
            ];
            $temp = LogicTag("{BLOGPOST}", "{/BLOGPOST}", $output);
            ParseTags($tags, $temp);
            $temp .= "\n{BLOGPOST}";
            ReplaceTag("{BLOGPOST}", $temp, $output); //Add this post to the output
        }

        RemoveLogicTag("{BLOGPOST}", "{/BLOGPOST}", $output);
        RemoveLogicTag("{COMMENT}", "{/COMMENT}", $output);

        //Clean up the tags if not already replaced
        $cleantags = [ "{PAGEPREVIOUSLINK}", "{PAGEPREVIOUSTEXT}", "{PAGENEXTLINK}", "{PAGENEXTTEXT}",
                        "{PAGINATION}", "{/PAGINATION}", "{NEWCOMMENT}", "{/NEWCOMMENT}" ];
        RemoveTags($cleantags, $output);

        parent::__construct($output);
    }
}
