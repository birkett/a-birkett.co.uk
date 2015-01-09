<?php
/**
* AdminListPostsPageController - pull data from model to populate the template
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

class AdminListPostsPageController extends AdminBasePageController
{
    /**
    * Build the List Posts page
    * @param string $output Unparsed template passed by reference
    * @return none
    */
    public function __construct(&$output)
    {
        parent::__construct($output);
        $this->model = new \ABirkett\models\AdminListPostsPageModel();
        $result = $this->model->getAllPosts();
        while ($row = $this->model->database->getRow($result)) {
            ($row['post_draft'] == "1") ? $draft = " (DRAFT)" : $draft = "";
            $tags = [
                "{ADMINFOLDER}" => ADMIN_FOLDER,
                "{POSTID}" => $row['post_id'],
                "{POSTTITLE}" => $row['post_title'] . $draft
            ];
            $temp = $this->templateEngine->logicTag(
                "{LOOP}",
                "{/LOOP}",
                $output
            );
            $this->templateEngine->parseTags($tags, $temp);
            $temp .= "\n{LOOP}";
            $this->templateEngine->replaceTag("{LOOP}", $temp, $output);
        }
        $this->templateEngine->removeLogicTag("{LOOP}", "{/LOOP}", $output);
    }
}
