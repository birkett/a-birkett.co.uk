<?php
//-----------------------------------------------------------------------------
// Build the listcomments page
//      In: Unparsed template
//      Out: Parsed template
//-----------------------------------------------------------------------------
namespace ABirkett;

class AdminListCommentsPageController extends AdminBasePageController
{
    public function __construct(&$output)
    {
        $te = TemplateEngine();

        if (isset($_GET['ip'])) {
            $result = GetAllComments($_GET['ip']);
        } else {
            $result = GetAllComments();
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
