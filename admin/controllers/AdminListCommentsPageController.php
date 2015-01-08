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
            $temp = LogicTag("{LOOP}", "{/LOOP}", $output);
            ParseTags($tags, $temp);
            $temp .= "\n{LOOP}";
            ReplaceTag("{LOOP}", $temp, $output);
        }
        RemoveLogicTag("{LOOP}", "{/LOOP}", $output);
        
        parent::__construct($output);
    }
}
