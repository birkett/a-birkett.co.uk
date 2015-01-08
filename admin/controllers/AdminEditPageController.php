<?php
//-----------------------------------------------------------------------------
// Build the editor page
//      In: Unparsed template
//      Out: Parsed template
//-----------------------------------------------------------------------------
namespace ABirkett;

class AdminEditPageController extends AdminBasePageController
{
    public function __construct(&$output)
    {
        $vars = "";
        if (isset($_GET['pageid'])) {
            //Page edit mode
            $page = GetPage($_GET['pageid']);
            $content = $page[1];

            $vars .= 'var pageid = document.getElementById("formpageid").value;';
            $vars .= 'var data = "mode=editpage&pageid="+pageid+"&content="+content;';

            ReplaceTag("{POSTID}", $_GET['pageid'], $output);
            RemoveLogicTag("{POSTEDIT}", "{/POSTEDIT}", $output);
            RemoveLogicTag("{NEWPOST}", "{/NEWPOST}", $output);
        } elseif (isset($_GET['postid'])) {
            //Post edit mode
            $post = GetPosts("single", $_GET['postid'], true);
            $row = GetDatabase()->getRow($post);
            list($postid, $timestamp, $title, $content, $draft) = $row;

            if ($draft) {
                $draft = "checked";
            }
            $vars .= 'var postid = document.getElementById("formpostid").value;';
            $vars .= 'var title = document.getElementById("formtitle").value;';
            $vars .= 'var draft = document.getElementById("formdraft").checked;';
            $vars .= 'var data = "mode=editpost&postid="+postid+"&title="+title+"&draft="+draft+"&content="+content;';

            $tags = [
                "{POSTID}" => $postid,
                "{POSTTITLE}" => $title,
                "{DRAFT}" => $draft
            ];
            ParseTags($tags, $output);
            RemoveLogicTag("{PAGEEDIT}", "{/PAGEEDIT}", $output);
            RemoveLogicTag("{NEWPOST}", "{/NEWPOST}", $output);
        } else {
            //New post mode
            $vars .= 'var title = document.getElementById("formtitle").value;';
            $vars .= 'var draft = document.getElementById("formdraft").checked;';
            $vars .= 'var data = "mode=newpost&title="+title+"&draft="+draft+"&content="+content;';

            RemoveLogicTag("{PAGEEDIT}", "{/PAGEEDIT}", $output);
            RemoveLogicTag("{POSTEDIT}", "{/POSTEDIT}", $output);
        }
        isset($content) ? $content = stripslashes($content) : $content = "";

        $tags = [
            "{VARS}" => $vars,
            "{CONTENT}" => $content
        ];
        ParseTags($tags, $output);
        //Clean up the tags if not already replaced
        $tags = [ "{NEWPOST}", "{/NEWPOST}", "{PAGEEDIT}", "{/PAGEEDIT}", "{POSTEDIT}", "{/POSTEDIT}" ];
        RemoveTags($tags, $output);

        parent::__construct($output);
    }
}
