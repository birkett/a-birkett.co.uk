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

use ABFramework\classes\SessionManager;
use ABFramework\controllers\AdminBasePageController;

/**
 * Handles generating the user widget.
 *
 * The user widget will show the currently logged in user, with a logout link.
 * If the user is not logged in, it will show the login form.
 *
 * @category  AdminControllers
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */
class AdminUserWidgetController extends AdminBasePageController
{


    /**
     * Build the User widget.
     *
     * @return none
     */
    public function __construct()
    {
        parent::__construct();

        $this->defineAction('GET', 'default', 'userWidgetGetHandler', array());
    }//end __construct()


    /**
     * Build the user account widget
     *
     * @return none
     */
    public function userWidgetGetHandler()
    {
        if ($this->sessionManager->isLoggedIn() === true) {
            $this->templateEngine->replaceTag(
                '{USERNAME}',
                $this->sessionManager->getVar('user'),
                $this->unparsedTemplate
            );

            return;
        }

        $this->unparsedTemplate = '';
	}//end userWidgetGetHandler()
}//end class
