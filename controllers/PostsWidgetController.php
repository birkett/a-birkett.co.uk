<?php
/**
 * PostsWidgetController - pull data from the model to populate the template
 *
 * PHP Version 5.3
 *
 * @category  Controllers
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\controllers;

class PostsWidgetController extends BasePageController
{


    /**
     * Build the posts widget
     * @param string $output Unparsed template passed by reference.
     * @return none
     */
    public function __construct(&$output)
    {
        parent::__construct($output);
        $this->model = new \ABirkett\models\PostsWidgetModel();
        $posts       = $this->model->getAllPosts();
        $postArray   = array();

        while ($post = $this->model->database->getRow($posts)) {
            $month = date('F Y', $post['post_timestamp']);
            $postArray[$month][] = array(
                                    'title' => $post['post_title'],
                                    'id'    => $post['post_id'],
                                   );
        }

        $monthloop = $this->templateEngine->logicTag(
            '{MONTHLOOP}',
            '{/MONTHLOOP}',
            $output
        );
        $itemloop  = $this->templateEngine->logicTag(
            '{ITEMLOOP}',
            '{/ITEMLOOP}',
            $output
        );
        foreach ($postArray as $month => $data) {
            $temp = $monthloop;
            $this->templateEngine->replaceTag('{MONTH}', $month, $temp);
            foreach ($data as $post) {
                $tempitem = $itemloop;
                $tags     = array(
                             '{POSTID}'    => $post['id'],
                             '{POSTTITLE}' => $post['title'],
                            );
                $this->templateEngine->parseTags($tags, $tempitem);
                $tempitem .= "\n{ITEMLOOP}";
                $this->templateEngine->replaceTag(
                    '{ITEMLOOP}',
                    $tempitem,
                    $temp
                );
            }//end foreach

            $temp .= "\n{MONTHLOOP}";
            $this->templateEngine->replaceTag('{MONTHLOOP}', $temp, $output);
            $this->templateEngine->removeLogicTag(
                '{ITEMLOOP}',
                '{/ITEMLOOP}',
                $output
            );
        }//end foreach

        $this->templateEngine->removeLogicTag(
            '{MONTHLOOP}',
            '{/MONTHLOOP}',
            $output
        );
        $tags = array(
                 '{ITEMS}',
                 '{MONTHS}',
                );
        $this->templateEngine->removeTags($tags, $output);

    }//end __construct()
}//end class
