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
 * @category  Classes
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\classes;

/**
 * Provides basic templating functionality.
 *
 * TemplateEngine is a singleton, so the value of getInstance() should be stored
 * in a class member.
 * Functions here will use by-reference parameters where appropriate, which
 * helps with saving some memory when passing the complete page template between
 * functions.
 *
 * @category  Classes
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */
class TemplateEngine
{


    /**
     * Singleton - return the instance
     * @return object Instance
     */
    public static function getInstance()
    {
        static $templateengine = null;
        if (isset($templateengine) === false) {
            $templateengine = new TemplateEngine();
        }

        return $templateengine;

    }//end getInstance()


    /**
     * Open a page template, taking into account if the page is in admin
     * @param string $file Input template filename.
     * @return string Template
     */
    public function loadPageTemplate($file)
    {
        return file_get_contents(__DIR__.'/../'.TEMPLATE_FOLDER.$file);

    }//end loadPageTemplate()


    /**
     * Open a sub template (widget, page content)
     * @param string $file Input subtemplate filename.
     * @return string SubTemplate
     */
    public function loadSubTemplate($file)
    {
        return file_get_contents(TEMPLATE_FOLDER.$file);

    }//end loadSubTemplate()


    /**
     * Replace a tag with a string (for inserting sub templates into the output)
     * @param string $tag    Tag to replace.
     * @param string $string String that will replace Tag.
     * @param string $output Unparsed template passed by reference.
     * @return void
     */
    public function replaceTag($tag, $string, &$output)
    {
        $output = str_replace($tag, $string, $output);

    }//end replaceTag()


    /**
     * Parse the tags in a given array to the template
     * @param array  $tags   Array of tags to replace by reference.
     * @param string $output Unparsed template passed by reference.
     * @return void
     */
    public function parseTags(&$tags, &$output)
    {
        $output = str_replace(array_keys($tags), $tags, $output);

    }//end parseTags()


    /**
     * Remove any left over tags from the parsed template
     * @param array  $tags   Array of tags to replace by reference.
     * @param string $output Unparsed template passed by reference.
     * @return void
     */
    public function removeTags(&$tags, &$output)
    {
        $output = str_replace($tags, '', $output);

    }//end removeTags()


    /**
     * Return the contents of a logic tag
     * @param string $start   Starting tag.
     * @param string $end     End tag.
     * @param string $content Unparsed template.
     * @return string Contents between Start and End tag
     */
    public function logicTag($start, $end, &$content)
    {
        $r = explode($start, $content);
        if (isset($r[1]) === true) {
            $r = explode($end, $r[1]);

            return $r[0];
        }

        return '';

    }//end logicTag()


    /**
     * Remove any left over logic tags from the parsed template
     * @param string $start   Starting tag.
     * @param string $end     End tag.
     * @param string $content Unparsed template.
     * @return void
     */
    public function removeLogicTag($start, $end, &$content)
    {
        $beginningPos = strpos($content, $start);
        $endPos       = strpos($content, $end);
        if ($beginningPos === false || $endPos === false) {
            return;
        }

        $textToDelete = substr(
            $content,
            $beginningPos,
            (($endPos + strlen($end)) - $beginningPos)
        );
        $content      = str_replace($textToDelete, '', $content);

    }//end removeLogicTag()
}//end class
