<?php
/**
* Templating engine functionality
*
* PHP Version 5.5
*
* @category Classes
* @package  PersonalWebsite
* @author   Anthony Birkett <anthony@a-birkett.co.uk>
* @license  http://opensource.org/licenses/MIT MIT
* @link     http://www.a-birkett.co.uk
*/
namespace ABirkett\classes;

class TemplateEngine
{
    /**
    * Singleton - return the instance
    * @return object Instance
    */
    public static function getInstance()
    {
        static $templateengine = null;
        if (!isset($templateengine)) {
            $templateengine = new TemplateEngine();
        }
        return $templateengine;
    }

    /**
    * Open a page template, taking into account if the page is in admin
    * @param string $file Input template filename
    * @return string Template
    */
    public function loadPageTemplate($file)
    {
        return file_get_contents(__DIR__ . "/../" . TEMPLATE_FOLDER . $file);
    }

    /**
    * Open a sub template (widget, page content)
    * @param string $file Input subtemplate filename
    * @return string SubTemplate
    */
    public function loadSubTemplate($file)
    {
        return file_get_contents(TEMPLATE_FOLDER . $file);
    }

    /**
    * Replace a tag with a string (for inserting sub templates into the output)
    * @param string $tag    Tag to replace
    * @param string $string String that will replace Tag
    * @param string $output Unparsed template passed by reference
    * @return none
    */
    public function replaceTag($tag, $string, &$output)
    {
        $output = str_replace($tag, $string, $output);
    }

    /**
    * Parse the tags in a given array to the template
    * @param mixed[] $tags   Array of tags to replace by reference
    * @param string  $output Unparsed template passed by reference
    * @return none
    */
    public function parseTags(&$tags, &$output)
    {
        $output = str_replace(array_keys($tags), $tags, $output);
    }

    /**
    * Remove any left over tags from the parsed template
    * @param mixed[] $tags   Array of tags to replace by reference
    * @param string  $output Unparsed template passed by reference
    * @return none
    */
    public function removeTags(&$tags, &$output)
    {
        $output = str_replace($tags, "", $output);
    }

    /**
    * Return the contents of a logic tag
    * @param string $start   Starting tag
    * @param string $end     End tag
    * @param string $content Unparsed template
    * @return string Contents between Start and End tag
    */
    public function logicTag($start, $end, &$content)
    {
        $r = explode($start, $content);
        if (isset($r[1])) {
            $r = explode($end, $r[1]);
            return $r[0];
        }
        return '';
    }

    /**
    * Remove any left over logic tags from the parsed template
    * @param string $start   Starting tag
    * @param string $end     End tag
    * @param string $content Unparsed template
    * @return none
    */
    public function removeLogicTag($start, $end, &$content)
    {
        $beginningPos = strpos($content, $start);
        $endPos = strpos($content, $end);
        if (!$beginningPos || !$endPos) {
            return;
        }
        $textToDelete = substr(
            $content,
            $beginningPos,
            ($endPos + strlen($end)) - $beginningPos
        );
        $content = str_replace($textToDelete, '', $content);
    }
}
