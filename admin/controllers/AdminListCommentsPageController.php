<?php
/**
* AdminListCommentsPageController - pull data from model to populate template
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

class AdminListCommentsPageController extends AdminBasePageController
{
    /**
    * Build the List Comments page
    * @param string $output Unparsed template passed by reference
    * @return none
    */
    public function __construct(&$output)
    {
        parent::__construct($output);
        $this->model = new \ABirkett\models\AdminListCommentsPageModel();

        if (isset($_GET['ip'])) {
            $result = $this->model->getAllComments($_GET['ip']);
        } else {
            $result = $this->model->getAllComments();
        }
        while ($row = $this->model->database->getRow($result)) {
            $tags = [
                "{COMMENT}" => $row['comment_text'],
                "{USERNAME}" => $row['comment_username'],
                "{TIMESTAMP}" => date(DATE_FORMAT, $row['comment_timestamp']),
                "{IP}" => $row['client_ip'],
                "{POSTID}" => $row['post_id']
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
