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
 * Test the Autoloader can find files in both root and admin directories.
 *
 * @category  Tests
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */
class AutoloaderTest extends \PHPUnit_Framework_TestCase
{


    /**
     * Test loading a root class.
     * @return none
     */
    public function testRootClassLoad()
    {
        //Loads from /classes.
        $controllerFactory = new \ABirkett\classes\ControllerFactory(
            'BasePageController',
            $blankPage
        );
        $this->assertNotNull($controllerFactory);

    }//end testRootClassLoad()


    /**
     * Test loading a root controller.
     * @return none
     */
    public function testRootControllerLoad()
    {
        //Loads from /controllers.
        $blankPage = '';
        $basePageController = new \ABirkett\controllers\BasePageController(
            $blankPage
        );
        $this->assertNotNull($basePageController);

    }//end testRootControllerLoad()


    /**
     * Test loading a root model.
     * @return none
     */
    public function testRootModelLoad()
    {
        //Loads from /models.
        $basePageModel = new \ABirkett\models\BasePageModel();
        $this->assertNotNull($basePageModel);

    }//end testRootModelLoad()


    /**
     * Test to make sure admin classes cannot be loaded from non admin pages.
     * The autoloader should fail to find the file, when the admin page symbol
     * is not defined before the call.
     * @return none
     */
    public function testAdminLoadFromRoot()
    {
        $this->setExpectedException(
            'Exception',
            'Class ABirkett\models\AdminBasePageModel not found.'
        );
        $adminModel = new \ABirkett\models\AdminBasePageModel();
        $this->assertNull($adminModel);

    }//end testAdminLoadFromRoot()


    /**
     * Test loading an admin controller.
     * @return none
     */
    public function testAdminControllerLoad()
    {
        //Loads from /admin/controllers.
        define('ADMINPAGE', true);
        $blankPage = '';
        $adminController = new \ABirkett\controllers\AdminBasePageController(
            $blankPage
        );
        $this->assertNotNull($adminController);

    }//end testAdminControllerLoad()


    /**
     * Test loading an admin model.
     * @return none
     */
    public function testAdminModelLoad()
    {
        //Loads from /admin/models.
        $adminBasePageModel = new \ABirkett\models\AdminBasePageModel();
        $this->assertNotNull($adminBasePageModel);

    }//end testAdminModelLoad()
}//end class
