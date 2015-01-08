<?php
//-----------------------------------------------------------------------------
// Build the editor page
//      In: Unparsed template
//      Out: Parsed template
//-----------------------------------------------------------------------------
namespace ABirkett;

class AdminEditPageController extends AdminBasePageController
{
    //-----------------------------------------------------------------------------
    // Fetch page content
    //		In: Page ID
    //		Out: Page title and content
    //-----------------------------------------------------------------------------
    private function getPage($pageid)
    {
        $db = GetDatabase();
        $page = $db->runQuery(
            "SELECT page_title, page_content FROM site_pages WHERE page_id = :pageid",
            array(":pageid" => $pageid)
        );
        return $page[0];
    }

    public function __construct(&$output)
    {
        $te = TemplateEngine();
        $vars = "";
        if (isset($_GET['pageid'])) {
            //Page edit mode
            $page = $this->getPage($_GET['pageid']);
            $content = $page['page_content'];

            $vars .= 'var pageid = document.getElementById("formpageid").value;';
            $vars .= 'var data = "mode=editpage&pageid="+pageid+"&content="+content;';

            $te->replaceTag("{POSTID}", $_GET['pageid'], $output);
            $te->removeLogicTag("{POSTEDIT}", "{/POSTEDIT}", $output);
            $te->removeLogicTag("{NEWPOST}", "{/NEWPOST}", $output);
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
            $te->parseTags($tags, $output);
            $te->removeLogicTag("{PAGEEDIT}", "{/PAGEEDIT}", $output);
            $te->removeLogicTag("{NEWPOST}", "{/NEWPOST}", $output);
        } else {
            //New post mode
            $vars .= 'var title = document.getElementById("formtitle").value;';
            $vars .= 'var draft = document.getElementById("formdraft").checked;';
            $vars .= 'var data = "mode=newpost&title="+title+"&draft="+draft+"&content="+content;';

            $te->removeLogicTag("{PAGEEDIT}", "{/PAGEEDIT}", $output);
            $te->removeLogicTag("{POSTEDIT}", "{/POSTEDIT}", $output);
        }
        isset($content) ? $content = stripslashes($content) : $content = "";

        $tags = [
            "{VARS}" => $vars,
            "{CONTENT}" => $content
        ];
        $te->parseTags($tags, $output);
        //Clean up the tags if not already replaced
        $tags = [ "{NEWPOST}", "{/NEWPOST}", "{PAGEEDIT}", "{/PAGEEDIT}", "{POSTEDIT}", "{/POSTEDIT}" ];
        $te->removeTags($tags, $output);

        parent::__construct($output);
    }
}
