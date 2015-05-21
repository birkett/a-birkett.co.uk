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
 * @category  Tests
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\Tests;

/**
 * Test the TemplateEngine correctly parses tags.
 *
 * @category  Tests
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */
class TemplateEngineTest extends \PHPUnit_Framework_TestCase
{


    /**
     * Create a known test string to be used by all the following tests.
     * @return string Test Data
     */
    public function createTestData()
    {
        return array(array('Hello {START}World{END}{/START} END'));

    }//end createTestData()


    /**
     * Replace a tag in a string with a given value.
     * @covers ABirkett\classes\TemplateEngine::replaceTag
     * @dataProvider createTestData
     * @param string $testData Test data provided by createTestData().
     * @return none
     */
    public function testReplaceTag($testData)
    {
        $templateEngine = new \ABirkett\classes\TemplateEngine();
        $out = $testData;
        $templateEngine->replaceTag('{END}', 'START', $out);

        $this->assertEquals($out, 'Hello {START}WorldSTART{/START} END');

    }//end testReplaceTag()


    /**
     * Parse a set of tags in a given array.
     * @covers ABirkett\classes\TemplateEngine::parseTags
     * @dataProvider createTestData
     * @param string $testData Test data provided by createTestData().
     * @return none
     */
    public function testParseTags($testData)
    {
        // Test replacing with empty and single space strings.
        $testArray = array(
                      '{START}' => '',
                      '{END}'   => ' ',
                     );

        $templateEngine = new \ABirkett\classes\TemplateEngine();
        $out = $testData;
        $templateEngine->parseTags($testArray, $out);

        $this->assertEquals($out, 'Hello World {/START} END');

    }//end testParseTags()


    /**
     * Remove a set of tags in a given array.
     * @covers ABirkett\classes\TemplateEngine::removeTags
     * @dataProvider createTestData
     * @param string $testData Test data provided by createTestData().
     * @return none
     */
    public function testRemoveTags($testData)
    {
        $testArray = array(
                      '{START}',
                      '{END}',
                     );

        $templateEngine = new \ABirkett\classes\TemplateEngine();
        $out = $testData;
        $templateEngine->removeTags($testArray, $out);

        $this->assertEquals($out, 'Hello World{/START} END');

    }//end testRemoveTags()


    /**
     * Test logic tags.
     * @covers ABirkett\classes\TemplateEngine::logicTag
     * @dataProvider createTestData
     * @param string $testData Test data provided by createTestData().
     * @return none
     */
    public function testLogicTag($testData)
    {
        $templateEngine = new \ABirkett\classes\TemplateEngine();
        $out = $testData;
        $tag = $templateEngine->logicTag('{START}', '{/START}', $out);

        $this->assertEquals($tag, 'World{END}');

    }//end testLogicTag()


    /**
     * Test removing logic tags.
     * @covers ABirkett\classes\TemplateEngine::removeLogicTag
     * @dataProvider createTestData
     * @param string $testData Test data provided by createTestData().
     * @return none
     */
    public function testRemoveLogicTag($testData)
    {
        $templateEngine = new \ABirkett\classes\TemplateEngine();
        $out = $testData;
        $templateEngine->removeLogicTag('{START}', '{/START}', $out);

        $this->assertEquals($out, 'Hello  END');

    }//end testRemoveLogicTag()
}//end class
