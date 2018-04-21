<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2018 Anthony Birkett
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
 * PHP Version 7.2
 *
 * @category  Entities
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2014-2018 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Page
 *
 * @ORM\Table(name="tblPage", uniqueConstraints={@ORM\UniqueConstraint(name="UK_intPageId", columns={"intPageId"})})
 * @ORM\Entity
 */
class Page
{
    /**
     * Page ID.
     *
     * @var integer
     *
     * @ORM\Column(name="intPageId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pageId;

    /**
     * Page name.
     *
     * @var string
     *
     * @ORM\Column(name="strName", type="string", length=40, nullable=false)
     */
    private $pageName;

    /**
     * Page content.
     *
     * @var string
     *
     * @ORM\Column(name="strContent", type="text", length=65535, nullable=false)
     */
    private $pageContent;

    /**
     * Page title.
     *
     * @var string
     *
     * @ORM\Column(name="strTitle", type="string", length=280, nullable=false)
     */
    private $pageTitle;


    /**
     * Get pageId.
     *
     * @return int|null
     */
    public function getPageId(): ?int
    {
        return $this->pageId;
    }//end getPageId()


    /**
     * Set pageName.
     *
     * @param string $pageName Page name.
     *
     * @return Page
     */
    public function setPageName(string $pageName): Page
    {
        $this->pageName = $pageName;

        return $this;
    }//end setPageName()


    /**
     * Get pageName.
     *
     * @return string|null
     */
    public function getPageName(): ?string
    {
        return $this->pageName;
    }//end getPageName()


    /**
     * Set pageContent.
     *
     * @param string $pageContent Page content.
     *
     * @return Page
     */
    public function setPageContent(string $pageContent): Page
    {
        $this->pageContent = $pageContent;

        return $this;
    }//end setPageContent()


    /**
     * Get pageContent.
     *
     * @return string|null
     */
    public function getPageContent(): ?string
    {
        return $this->pageContent;
    }//end getPageContent()


    /**
     * Set pageTitle.
     *
     * @param string $pageTitle Page title.
     *
     * @return Page
     */
    public function setPageTitle(string $pageTitle): Page
    {
        $this->pageTitle = $pageTitle;

        return $this;
    }//end setPageTitle()


    /**
     * Get pageTitle.
     *
     * @return string|null
     */
    public function getPageTitle(): ?string
    {
        return $this->pageTitle;
    }//end getPageTitle()
}//end class
