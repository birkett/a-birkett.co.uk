<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BlogPosts
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BlogPostsRepository")
 * @ORM\Table(name="blog_posts", uniqueConstraints={@ORM\UniqueConstraint(name="post_id_UNIQUE", columns={"postID"})})
 */
class BlogPosts
{
    /**
     * @var integer
     *
     * @ORM\Column(name="postID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $postid;

    /**
     * @var integer
     *
     * @ORM\Column(name="postTimestamp", type="integer", nullable=false)
     */
    private $posttimestamp;

    /**
     * @var string
     *
     * @ORM\Column(name="postTitle", type="string", length=280, nullable=false)
     */
    private $posttitle;

    /**
     * @var string
     *
     * @ORM\Column(name="postContent", type="text", length=65535, nullable=false)
     */
    private $postcontent;

    /**
     * @var boolean
     *
     * @ORM\Column(name="postDraft", type="boolean", nullable=false)
     */
    private $postdraft;

    /**
     * @var boolean
     *
     * @ORM\Column(name="postTweeted", type="boolean", nullable=false)
     */
    private $posttweeted;

    /**
     * @var BlogComments[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="BlogComments", mappedBy="postid")
     */
    private $comments;

    /**
     * Get postid
     *
     * @return integer
     */
    public function getPostid()
    {
        return $this->postid;
    }

    /**
     * Set posttimestamp
     *
     * @param integer $posttimestamp
     *
     * @return BlogPosts
     */
    public function setPosttimestamp($posttimestamp)
    {
        $this->posttimestamp = $posttimestamp;

        return $this;
    }

    /**
     * Get posttimestamp
     *
     * @return integer
     */
    public function getPosttimestamp()
    {
        return $this->posttimestamp;
    }

    /**
     * Set posttitle
     *
     * @param string $posttitle
     *
     * @return BlogPosts
     */
    public function setPosttitle($posttitle)
    {
        $this->posttitle = $posttitle;

        return $this;
    }

    /**
     * Get posttitle
     *
     * @return string
     */
    public function getPosttitle()
    {
        return $this->posttitle;
    }

    /**
     * Set postcontent
     *
     * @param string $postcontent
     *
     * @return BlogPosts
     */
    public function setPostcontent($postcontent)
    {
        $this->postcontent = $postcontent;

        return $this;
    }

    /**
     * Get postcontent
     *
     * @return string
     */
    public function getPostcontent()
    {
        return $this->postcontent;
    }

    /**
     * Set postdraft
     *
     * @param boolean $postdraft
     *
     * @return BlogPosts
     */
    public function setPostdraft($postdraft)
    {
        $this->postdraft = $postdraft;

        return $this;
    }

    /**
     * Get postdraft
     *
     * @return boolean
     */
    public function getPostdraft()
    {
        return $this->postdraft;
    }

    /**
     * Set posttweeted
     *
     * @param boolean $posttweeted
     *
     * @return BlogPosts
     */
    public function setPosttweeted($posttweeted)
    {
        $this->posttweeted = $posttweeted;

        return $this;
    }

    /**
     * Get posttweeted
     *
     * @return boolean
     */
    public function getPosttweeted()
    {
        return $this->posttweeted;
    }

    /**
     * Get comments
     *
     * @return BlogComments[]|ArrayCollection
     */
    public function getComments()
    {
        return $this->comments;
    }

    public function getCommentsCount()
    {
        return count($this->comments);
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add comment
     *
     * @param \AppBundle\Entity\BlogComments $comment
     *
     * @return BlogPosts
     */
    public function addComment(\AppBundle\Entity\BlogComments $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \AppBundle\Entity\BlogComments $comment
     */
    public function removeComment(\AppBundle\Entity\BlogComments $comment)
    {
        $this->comments->removeElement($comment);
    }
}
