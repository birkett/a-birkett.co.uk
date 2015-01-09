<?php
//-----------------------------------------------------------------------------
// Template engine class
//
//  Basic functions to use when building a templated page
//-----------------------------------------------------------------------------
namespace ABirkett\classes;

class TemplateEngine
{
    //-----------------------------------------------------------------------------
    // Get a TemplateEngine instance
    //		In: none
    //		Out: TemplateEngine object
    //-----------------------------------------------------------------------------
    public static function getInstance()
    {
        static $templateengine = null;
        if (!isset($templateengine)) {
            $templateengine = new TemplateEngine();
        }
        return $templateengine;
    }

    //-----------------------------------------------------------------------------
    // Open a page template, taking into account if the requested page is in admin
    //		In: Filename
    //		Out: Unparsed template
    //-----------------------------------------------------------------------------
    public function loadPageTemplate($filename)
    {
        return file_get_contents(__DIR__ . "/../" . TEMPLATE_FOLDER . $filename);
    }

    //-----------------------------------------------------------------------------
    // Open a sub template (widget, page content)
    //		In: Filename
    //		Out: Unparsed (sub)template
    //-----------------------------------------------------------------------------
    public function loadSubTemplate($filename)
    {
        return file_get_contents(TEMPLATE_FOLDER . $filename);
    }

    //-----------------------------------------------------------------------------
    // Replace a tag with a string (for inserting sub templates into the output)
    //		In: Tag and parsed sub template
    //		Out: Parsed template
    //-----------------------------------------------------------------------------
    public function replaceTag($tag, $string, &$output)
    {
        $output = str_replace($tag, $string, $output);
    }

    //-----------------------------------------------------------------------------
    // Parse the tags in a given array to the template
    //		In: Tags and Unparsed template
    //		Out: Parsed template
    //-----------------------------------------------------------------------------
    public function parseTags(&$tags, &$output)
    {
        $output = str_replace(array_keys($tags), $tags, $output);
    }

    //-----------------------------------------------------------------------------
    // Remove any left over tags from the parsed template
    //		In: Tags and Parsed template
    //		Out: Clean Parsed template
    //-----------------------------------------------------------------------------
    public function removeTags(&$tags, &$output)
    {
        $output = str_replace($tags, "", $output);
    }

    //-----------------------------------------------------------------------------
    // Return the contents of a logic tag
    //		In: Tags and Unparsed template
    //		Out: String from between $start and $end
    //
    //  Logic tags can be loops, i.e. {LOOP} content {/LOOP}
    //-----------------------------------------------------------------------------
    public function logicTag($start, $end, &$content)
    {
        $r = explode($start, $content);
        if (isset($r[1])) {
            $r = explode($end, $r[1]);
            return $r[0];
        }
        return '';
    }

    //-----------------------------------------------------------------------------
    // Remove any left over logic tags from the parsed template
    //		In: Tags and Parsed template
    //		Out: Clean Parsed template
    //-----------------------------------------------------------------------------
    public function removeLogicTag($start, $end, &$content)
    {
        $beginningPos = strpos($content, $start);
        $endPos = strpos($content, $end);
        if (!$beginningPos || !$endPos) {
            return;
        }
        $textToDelete = substr($content, $beginningPos, ($endPos + strlen($end)) - $beginningPos);
        $content = str_replace($textToDelete, '', $content);
    }
}
