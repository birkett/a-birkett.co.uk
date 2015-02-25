<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2015 Anthony Birkett
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 *
 * PHP Version 5.3
 *
 * @category  Controllers
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\controllers;

/**
 * Handles generating the posts widget on the blog.
 *
 * The generated widget will order all posts by Month, then allow each month to
 * be collapsed down by Javascript.
 * The logic starts by putting each post into an array, ordered by Month. The
 * array is then parsed out, and the MONTHLOOP and ITEMLOOP tags are replaced.
 *
 * @category  Controllers
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */
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
