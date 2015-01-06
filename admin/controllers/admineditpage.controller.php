<?php
//-----------------------------------------------------------------------------
// Build the editor page
//      In: Unparsed template
//      Out: Parsed template
//-----------------------------------------------------------------------------
namespace ABirkett;

class AdminEditPageController
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
            $row = GetDatabase()->getRow(GetPosts("single", $_GET['postid'], true));
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
        ReplaceTag("{VARS}", $vars, $output);
        isset($content) ? $content = $content : $content = "";
        ReplaceTag("{CONTENT}", $content, $output);
        //Clean up the tags if not already replaced
        $cleantags = [ "{NEWPOST}", "{/NEWPOST}", "{PAGEEDIT}", "{/PAGEEDIT}", "{POSTEDIT}", "{/POSTEDIT}" ];
        RemoveTags($cleantags, $output);
    }
}
