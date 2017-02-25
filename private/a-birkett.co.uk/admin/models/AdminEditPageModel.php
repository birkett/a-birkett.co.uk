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
 * @category  AdminModels
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\models;

/**
 * Handles data for the editor pages. Glue between the database and controller.
 *
 * The methods here simply fetch the needed data from the database.
 *
 * @category  AdminModels
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */
class AdminEditPageModel extends AdminBasePageModel
{


    /**
     * Fetch a page
     * @param  integer $pageid ID of the page to fetch.
     * @return array   Array containing page data
     */
    public function getPage($pageid)
    {
        $page = $this->database->runQuery(
            'SELECT pageTitle, pageContent FROM site_pages WHERE pageID = :pid',
            array(':pid' => $pageid)
        );

        $row = $this->database->getRow($page);

        return $row;

    }//end getPage()


    /**
     * Fetch a post
     * @param  integer $postid ID of the post to fetch.
     * @return array   Array containing post data
     */
    public function getSinglePost($postid)
    {
        $post = $this->database->runQuery(
            'SELECT * FROM blog_posts WHERE postID = :id',
            array(':id' => $postid)
        );

        $row = $this->database->getRow($post);

        return $row;

    }//end getSinglePost()
}//end class