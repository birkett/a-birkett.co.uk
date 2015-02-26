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
 * @category  AdminControllers
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\controllers;

/**
 * Handles generating the admin editor pages.
 *
 * This can actually generate 3 different pages, the page editor, post editor,
 * or new post editor.
 *
 * There is a small ammount of Javascript being added to the page here, it would
 * be nice to remove that, and just remove it conditionally from the template.
 *
 * @category  AdminControllers
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */
class AdminEditPageController extends AdminBasePageController
{

    /**
     * Remove unused tags from the page
     * @param string $output Page to render to.
     * @return none
     */
    private function cleanupTags(&$output)
    {
        // Clean up the tags if not already replaced.
        $tags = array(
                 '{NEWPOST}',
                 '{/NEWPOST}',
                 '{PAGEEDIT}',
                 '{/PAGEEDIT}',
                 '{POSTEDIT}',
                 '{/POSTEDIT}',
                );
        $this->templateEngine->removeTags($tags, $output);

    }//end cleanupTags()


    /**
     * Build an editor page
     * @param string $output Unparsed template passed by reference.
     * @return none
     */
    public function __construct(&$output)
    {
        parent::__construct($output);

        $this->model = new \ABirkett\models\AdminEditPageModel();

        $pageid = filter_input(INPUT_GET, 'pageid', FILTER_SANITIZE_NUMBER_INT);
        $postid = filter_input(INPUT_GET, 'postid', FILTER_SANITIZE_NUMBER_INT);

        // Page edit mode.
        if (isset($pageid) === true) {
            $page = $this->model->getPage($pageid);
            $cont = $page['page_content'];

            $vars  = 'var pageid=document.getElementById("formpageid").value;';
            $vars .=
                'var data="mode=editpage&pageid="+pageid+"&content="+content;';

            $this->templateEngine->replaceTag('{POSTID}', $pageid, $output);
            $this->templateEngine->removeLogicTag(
                '{POSTEDIT}',
                '{/POSTEDIT}',
                $output
            );
            $this->templateEngine->removeLogicTag(
                '{NEWPOST}',
                '{/NEWPOST}',
                $output
            );
        }//end if

        // Post edit mode.
        if (isset($postid) === true && isset($pageid) === false) {
            $post = $this->model->getSinglePost($postid);
            $row  = $this->model->database->getRow($post);

            $cont = $row['post_content'];

            $vars  = 'var postid=document.getElementById("formpostid").value;';
            $vars .= 'var title=document.getElementById("formtitle").value;';
            $vars .= 'var draft='.
                'document.getElementById("formdraft").checked;';
            $vars .= 'var data="mode=editpost&postid="+postid+"&title="'.
                '+title+"&draft="+draft+"&content="+content;';

            // Small conversion to set checkbox value.
            $checked = ($row['post_draft'] === '1') ? 'checked' : '';

            $tags = array(
                     '{POSTID}'    => $row['post_id'],
                     '{POSTTITLE}' => $row['post_title'],
                     '{DRAFT}'     => $checked,
                    );
            $this->templateEngine->parseTags($tags, $output);
            $this->templateEngine->removeLogicTag(
                '{PAGEEDIT}',
                '{/PAGEEDIT}',
                $output
            );
            $this->templateEngine->removeLogicTag(
                '{NEWPOST}',
                '{/NEWPOST}',
                $output
            );
        }//end if

        // New post mode.
        if (isset($pageid) === false && isset($postid) === false) {
            $cont  = '';
            $vars  = 'var title=document.getElementById("formtitle").value;';
            $vars .= 'var draft=document.getElementById("formdraft").checked;';
            $vars .= 'var data="mode=newpost&title="+title+"&draft="'.
                '+draft+"&content="+content;';

            $this->templateEngine->removeLogicTag(
                '{PAGEEDIT}',
                '{/PAGEEDIT}',
                $output
            );
            $this->templateEngine->removeLogicTag(
                '{POSTEDIT}',
                '{/POSTEDIT}',
                $output
            );
        }//end if

        $tags = array(
                 '{VARS}'    => $vars,
                 '{CONTENT}' => stripslashes($cont),
                );
        $this->templateEngine->parseTags($tags, $output);

        $this->cleanupTags($output);

    }//end __construct()
}//end class
