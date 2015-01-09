<?php
/**
* AdminEditPageController - pull data from the model to populate the template
*
* PHP Version 5.5
*
* @category AdminControllers
* @package  PersonalWebsite
* @author   Anthony Birkett <anthony@a-birkett.co.uk>
* @license  http://opensource.org/licenses/MIT MIT
* @link     http://www.a-birkett.co.uk
*/
namespace ABirkett\controllers;

class AdminEditPageController extends AdminBasePageController
{
    /**
    * Build an editor page
    * @param string $output Unparsed template passed by reference
    * @return none
    */
    public function __construct(&$output)
    {
        parent::__construct($output);

        $this->model = new \ABirkett\models\AdminEditPageModel();
        $vars = "";
        if (isset($_GET['pageid'])) {
            //Page edit mode
            $page = $this->model->getPage($_GET['pageid']);
            $content = $page['page_content'];

            $vars .= 'var pageid = document.getElementById("formpageid").value;';
            $vars .= 'var data = "mode=editpage&pageid="+pageid+"&content="+content;';

            $this->templateEngine->replaceTag("{POSTID}", $_GET['pageid'], $output);
            $this->templateEngine->removeLogicTag("{POSTEDIT}", "{/POSTEDIT}", $output);
            $this->templateEngine->removeLogicTag("{NEWPOST}", "{/NEWPOST}", $output);
        } elseif (isset($_GET['postid'])) {
            //Post edit mode
            $post = $this->model->getSinglePost($_GET['postid']);
            $row = $this->model->database->getRow($post);
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
            $this->templateEngine->parseTags($tags, $output);
            $this->templateEngine->removeLogicTag("{PAGEEDIT}", "{/PAGEEDIT}", $output);
            $this->templateEngine->removeLogicTag("{NEWPOST}", "{/NEWPOST}", $output);
        } else {
            //New post mode
            $vars .= 'var title = document.getElementById("formtitle").value;';
            $vars .= 'var draft = document.getElementById("formdraft").checked;';
            $vars .= 'var data = "mode=newpost&title="+title+"&draft="+draft+"&content="+content;';

            $this->templateEngine->removeLogicTag("{PAGEEDIT}", "{/PAGEEDIT}", $output);
            $this->templateEngine->removeLogicTag("{POSTEDIT}", "{/POSTEDIT}", $output);
        }
        isset($content) ? $content = stripslashes($content) : $content = "";

        $tags = [
            "{VARS}" => $vars,
            "{CONTENT}" => $content
        ];
        $this->templateEngine->parseTags($tags, $output);
        //Clean up the tags if not already replaced
        $tags = [ "{NEWPOST}", "{/NEWPOST}", "{PAGEEDIT}", "{/PAGEEDIT}", "{POSTEDIT}", "{/POSTEDIT}" ];
        $this->templateEngine->removeTags($tags, $output);
    }
}
