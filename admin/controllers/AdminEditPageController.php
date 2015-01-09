<?php
//-----------------------------------------------------------------------------
// Build the editor page
//      In: Unparsed template
//      Out: Parsed template
//-----------------------------------------------------------------------------
namespace ABirkett\controllers;

class AdminEditPageController extends AdminBasePageController
{
    private $model;

    public function __construct(&$output)
    {
        $this->model = new \ABirkett\models\AdminEditPageModel();
        $te = \ABirkett\TemplateEngine();
        $vars = "";
        if (isset($_GET['pageid'])) {
            //Page edit mode
            $page = $this->model->getPage($_GET['pageid']);
            $content = $page['page_content'];

            $vars .= 'var pageid = document.getElementById("formpageid").value;';
            $vars .= 'var data = "mode=editpage&pageid="+pageid+"&content="+content;';

            $te->replaceTag("{POSTID}", $_GET['pageid'], $output);
            $te->removeLogicTag("{POSTEDIT}", "{/POSTEDIT}", $output);
            $te->removeLogicTag("{NEWPOST}", "{/NEWPOST}", $output);
        } elseif (isset($_GET['postid'])) {
            //Post edit mode
            $post = $this->model->getSinglePost($_GET['postid']);
            $row = \ABirkett\GetDatabase()->getRow($post);
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
