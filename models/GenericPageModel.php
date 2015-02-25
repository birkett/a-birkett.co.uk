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
 * @category  Models
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\models;

/**
 * Handles the data for generic, database stored, pages.
 *
 * The query in getPage() can fail if the page isnt found, so it returns null
 * when appropriate. This prevents a PHP warning when $page isnt defined.
 *
 * This might need to be looked into further, because the problem isnt actually
 * here, its in the database class. The query is wrapped in a try{}catch{}
 * block, and the exception does get thrown when the query fails. This should
 * really have an effect, rather than failing to return anything.
 *
 * @category  Models
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */
class GenericPageModel extends BasePageModel
{


    /**
     * Get the page data and return it as an array
     * @param  string $pagename Name of the page to fetch.
     * @return array  Array of page data
     */
    public function getPage($pagename)
    {
        $page = $this->database->runQuery(
            'SELECT page_title, page_content FROM site_pages'.
            ' WHERE page_name = :pn',
            array(':pn' => $pagename)
        );

        if (empty($page) === true) {
            return null;
        } else {
            return $page[0];
        }

    }//end getPage()
}//end class
