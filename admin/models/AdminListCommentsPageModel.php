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
 * Handles data for the list comments page controller.
 *
 * The method getAllComments() will check the $ip parameter, if it is set, the
 * query will only return comments matching the given IP.
 *
 * @category  AdminModels
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */
class AdminListCommentsPageModel extends AdminBasePageModel
{


    /**
     * Fetch a list of all comments
     * @param  string $ipaddress Optional IP address to filter fetched comments.
     * @return array  Array of comments data
     */
    public function getAllComments($ipaddress)
    {
        $fil = ' WHERE clientIP="'.$ipaddress.'"';

        if ($ipaddress === null) {
            $fil = ' ';
        }

        return $this->database->runQuery(
            'SELECT * FROM blog_comments'.$fil.'ORDER BY commentTimestamp DESC',
            array()
        );

    }//end getAllComments()
}//end class
