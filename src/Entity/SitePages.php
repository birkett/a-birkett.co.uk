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
 * PHP Version 7.1
 *
 * @category  Entities
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015-2018 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */


declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SitePages
 *
 * @ORM\Table(name="site_pages", uniqueConstraints={@ORM\UniqueConstraint(name="page_id_UNIQUE", columns={"pageID"})})
 * @ORM\Entity
 */
class SitePages
{
    /**
     * @var int
     *
     * @ORM\Column(name="pageID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pageId;

    /**
     * @var string
     *
     * @ORM\Column(name="pageName", type="string", length=40, nullable=false)
     */
    private $pageName;

    /**
     * @var string
     *
     * @ORM\Column(name="pageContent", type="text", length=65535, nullable=false)
     */
    private $pageContent;

    /**
     * @var string
     *
     * @ORM\Column(name="pageTitle", type="string", length=280, nullable=false)
     */
    private $pageTitle;

    /**
     * Get pageId
     *
     * @return int
     */
    public function getPageId(): int
    {
        return $this->pageId;
    }

    /**
     * Set pageName
     *
     * @param string $pageName
     *
     * @return SitePages
     */
    public function setPageName($pageName): SitePages
    {
        $this->pageName = $pageName;

        return $this;
    }

    /**
     * Get pageName
     *
     * @return string
     */
    public function getPageName(): string
    {
        return $this->pageName;
    }

    /**
     * Set pageContent
     *
     * @param string $pageContent
     *
     * @return SitePages
     */
    public function setPageContent($pageContent): SitePages
    {
        $this->pageContent = $pageContent;

        return $this;
    }

    /**
     * Get pageContent
     *
     * @return string
     */
    public function getPageContent(): string
    {
        return $this->pageContent;
    }

    /**
     * Set pageTitle
     *
     * @param string $pageTitle
     *
     * @return SitePages
     */
    public function setPageTitle($pageTitle): SitePages
    {
        $this->pageTitle = $pageTitle;

        return $this;
    }

    /**
     * Get pageTitle
     *
     * @return string
     */
    public function getPageTitle(): string
    {
        return $this->pageTitle;
    }
}
