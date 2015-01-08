<?php
//-----------------------------------------------------------------------------
// Build the listposts page
//      In: Unparsed template
//      Out: Parsed template
//-----------------------------------------------------------------------------
namespace ABirkett;

class AdminListPostsPageController extends AdminBasePageController
{
    public function __construct(&$output)
    {
        $result = GetPosts("all", 0, true);
        while (list($id, $timestamp, $title, $draft) = GetDatabase()->getRow($result)) {
            $draft ? $title .= " (DRAFT)" : $title .= "";
            $tags = [
                "{ADMINFOLDER}" => ADMIN_FOLDER,
                "{POSTID}" => $id,
                "{POSTTITLE}" => $title
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
