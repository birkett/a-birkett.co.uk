<?php

namespace WebsiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BlogComments
 *
 * @ORM\Table(name="blog_comments", uniqueConstraints={@ORM\UniqueConstraint(name="comment_id_UNIQUE", columns={"commentID"})})
 * @ORM\Entity
 */
class BlogComments
{
    /**
     * @var integer
     *
     * @ORM\Column(name="commentID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $commentid;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="BlogPosts", inversedBy="comments")
     * @ORM\JoinColumn(name="postid", referencedColumnName="postID")
     */
    private $postid;

    /**
     * @var string
     *
     * @ORM\Column(name="commentUsername", type="string", length=100, nullable=false)
     */
    private $commentusername;

    /**
     * @var string
     *
     * @ORM\Column(name="commentText", type="string", length=4000, nullable=false)
     */
    private $commenttext;

    /**
     * @var integer
     *
     * @ORM\Column(name="commentTimestamp", type="integer", nullable=false)
     */
    private $commenttimestamp;

    /**
     * @var string
     *
     * @ORM\Column(name="clientIP", type="string", length=180, nullable=false)
     */
    private $clientip;



    /**
     * Get commentid
     *
     * @return integer
     */
    public function getCommentid()
    {
        return $this->commentid;
    }

    /**
     * Set postid
     *
     * @param integer $postid
     *
     * @return BlogComments
     */
    public function setPostid($postid)
    {
        $this->postid = $postid;

        return $this;
    }

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
     * Set commentusername
     *
     * @param string $commentusername
     *
     * @return BlogComments
     */
    public function setCommentusername($commentusername)
    {
        $this->commentusername = $commentusername;

        return $this;
    }

    /**
     * Get commentusername
     *
     * @return string
     */
    public function getCommentusername()
    {
        return $this->commentusername;
    }

    /**
     * Set commenttext
     *
     * @param string $commenttext
     *
     * @return BlogComments
     */
    public function setCommenttext($commenttext)
    {
        $this->commenttext = $commenttext;

        return $this;
    }

    /**
     * Get commenttext
     *
     * @return string
     */
    public function getCommenttext()
    {
        return $this->commenttext;
    }

    /**
     * Set commenttimestamp
     *
     * @param integer $commenttimestamp
     *
     * @return BlogComments
     */
    public function setCommenttimestamp($commenttimestamp)
    {
        $this->commenttimestamp = $commenttimestamp;

        return $this;
    }

    /**
     * Get commenttimestamp
     *
     * @return integer
     */
    public function getCommenttimestamp()
    {
        return $this->commenttimestamp;
    }

    /**
     * Set clientip
     *
     * @param string $clientip
     *
     * @return BlogComments
     */
    public function setClientip($clientip)
    {
        $this->clientip = $clientip;

        return $this;
    }

    /**
     * Get clientip
     *
     * @return string
     */
    public function getClientip()
    {
        return $this->clientip;
    }
}
