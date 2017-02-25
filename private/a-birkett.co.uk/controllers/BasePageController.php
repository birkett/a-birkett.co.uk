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
 * Handles the common tags which are present on all pages.
 *
 * Every page will be passed through this controller automatically, as all other
 * page controllers inherit from this, and call parent::__construct().
 *
 * Because everything else inherits this, we also store the page model and a
 * TemplateEngine instance here. These are protected, so are accessible from
 * child classes.
 *
 * @category  Controllers
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */
class BasePageController
{

    /**
     * Store an instance of the model for child controller to use
     * @var object $model
     */
    protected $model;

    /**
     * Store an instance of the template engine for child controllers to use
     * @var object $templateEngine
     */
    protected $templateEngine;


    /**
     * Parse some common tags present in most (if not all) templates
     * @param string $output Unparsed template passed by reference.
     * @return none
     */
    public function __construct(&$output)
    {
        $this->model          = new \ABirkett\models\BasePageModel();
        $this->templateEngine = new \ABirkett\classes\TemplateEngine();

        $tags = array(
                 '{BASEURL}'  => $this->model->getBaseURL(),
                 '{RAND2551}' => rand(0, 255),
                 '{RAND2552}' => rand(0, 255),
                 '{RAND2553}' => rand(0, 255),
                 '{RAND12}'   => rand(1, 2),
                 '{THISYEAR}' => date('Y'),
                );
        $this->templateEngine->parseTags($tags, $output);

        if (CHRISTMAS === 1) {
            $tags = array(
                     '{EXTRASTYLESHEETS}',
                     '{/EXTRASTYLESHEETS}',
                    );
            $this->templateEngine->removeTags($tags, $output);
        }

        // Remove the extra stylesheet tags if something above hanst used them.
        $this->templateEngine->removeLogicTag(
            '{EXTRASTYLESHEETS}',
            '{/EXTRASTYLESHEETS}',
            $output
        );

        if (defined('ADMINPAGE') === false) {
            $this->templateEngine->removeLogicTag(
                '{ADMINSTYLESHEET}',
                '{/ADMINSTYLESHEET}',
                $output
            );
            $this->templateEngine->replaceTag('{ADMINFOLDER}', '', $output);
        }

    }//end __construct()
}//end class
