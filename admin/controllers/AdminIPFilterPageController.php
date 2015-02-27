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
 * Handles generating the IP filter page.
 *
 * The IP filter page can add a new IP address to the block list, or remove an
 * address already present.
 *
 * @category  AdminControllers
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */
class AdminIPFilterPageController extends AdminBasePageController
{


    /**
     * Build the IP blacklist page
     * @param string $output Unparsed template passed by reference.
     * @return none
     */
    public function __construct(&$output)
    {
        parent::__construct($output);
        $this->model = new \ABirkett\models\AdminIPFilterPageModel();
        $result      = $this->model->getBlockedAddresses();

        foreach ($result as $row) {
            $time = $row->blocked_timestamp;
            $tags = array(
                     '{IP}'        => $row->address,
                     '{TIMESTAMP}' => date(DATE_FORMAT, $time),
                    );
            $temp = $this->templateEngine->logicTag(
                '{LOOP}',
                '{/LOOP}',
                $output
            );
            $this->templateEngine->parseTags($tags, $temp);
            $temp .= "\n{LOOP}";
            $this->templateEngine->replaceTag('{LOOP}', $temp, $output);
        }//end foreach

        $this->templateEngine->removeLogicTag('{LOOP}', '{/LOOP}', $output);

    }//end __construct()
}//end class
