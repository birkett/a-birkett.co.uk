<?php
//-----------------------------------------------------------------------------
// Build the listcomments page
//      In: Unparsed template
//      Out: Parsed template
//-----------------------------------------------------------------------------
namespace ABirkett;

class AdminListCommentsPageController extends AdminBasePageController
{
    //-----------------------------------------------------------------------------
    // Fetch all comments
    //      In: Optional IP Address
    //      Out: All comment data
    //-----------------------------------------------------------------------------
    private function getAllComments($ip = "")
    {
        return GetDatabase()->runQuery(
            "SELECT * FROM blog_comments" . ($ip == "" ? " " : " WHERE client_ip='$ip' ") .
            "ORDER BY comment_timestamp DESC",
            array()
        );
    }

    public function __construct(&$output)
    {
        $te = TemplateEngine();

        if (isset($_GET['ip'])) {
            $result = $this->getAllComments($_GET['ip']);
        } else {
            $result = $this->getAllComments();
        }
        while (list($id, $postid, $username, $comment, $timestamp, $ip) = GetDatabase()->getRow($result)) {
            $tags = [
                "{COMMENT}" => $comment,
                "{USERNAME}" => $username,
                "{TIMESTAMP}" => date(DATE_FORMAT, $timestamp),
                "{IP}" => $ip,
                "{POSTID}" => $postid
            ];
            $temp = $te->logicTag("{LOOP}", "{/LOOP}", $output);
            $te->parseTags($tags, $temp);
            $temp .= "\n{LOOP}";
            $te->replaceTag("{LOOP}", $temp, $output);
        }
        $te->removeLogicTag("{LOOP}", "{/LOOP}", $output);

        parent::__construct($output);
    }
}
