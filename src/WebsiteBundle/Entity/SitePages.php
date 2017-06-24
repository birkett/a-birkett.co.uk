<?php

namespace WebsiteBundle\Entity;

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
     * @var integer
     *
     * @ORM\Column(name="pageID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pageid;

    /**
     * @var string
     *
     * @ORM\Column(name="pageName", type="string", length=40, nullable=false)
     */
    private $pagename;

    /**
     * @var string
     *
     * @ORM\Column(name="pageContent", type="text", length=65535, nullable=false)
     */
    private $pagecontent;

    /**
     * @var string
     *
     * @ORM\Column(name="pageTitle", type="string", length=280, nullable=false)
     */
    private $pagetitle;



    /**
     * Get pageid
     *
     * @return integer
     */
    public function getPageid()
    {
        return $this->pageid;
    }

    /**
     * Set pagename
     *
     * @param string $pagename
     *
     * @return SitePages
     */
    public function setPagename($pagename)
    {
        $this->pagename = $pagename;

        return $this;
    }

    /**
     * Get pagename
     *
     * @return string
     */
    public function getPagename()
    {
        return $this->pagename;
    }

    /**
     * Set pagecontent
     *
     * @param string $pagecontent
     *
     * @return SitePages
     */
    public function setPagecontent($pagecontent)
    {
        $this->pagecontent = $pagecontent;

        return $this;
    }

    /**
     * Get pagecontent
     *
     * @return string
     */
    public function getPagecontent()
    {
        return $this->pagecontent;
    }

    /**
     * Set pagetitle
     *
     * @param string $pagetitle
     *
     * @return SitePages
     */
    public function setPagetitle($pagetitle)
    {
        $this->pagetitle = $pagetitle;

        return $this;
    }

    /**
     * Get pagetitle
     *
     * @return string
     */
    public function getPagetitle()
    {
        return $this->pagetitle;
    }
}
