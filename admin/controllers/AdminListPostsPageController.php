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
        $te = TemplateEngine();
        $result = GetPosts("all", 0, true);
        while (list($id, $timestamp, $title, $draft) = GetDatabase()->getRow($result)) {
            $draft ? $title .= " (DRAFT)" : $title .= "";
            $tags = [
                "{ADMINFOLDER}" => ADMIN_FOLDER,
                "{POSTID}" => $id,
                "{POSTTITLE}" => $title
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
