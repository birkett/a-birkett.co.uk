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
 * PHP Version 5.6
 *
 * @category  Entities
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */

/* Entity for a blog comment. */
namespace WebsiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BlogComments
 *
 * @ORM\Table(
 *     name="blog_comments",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="comment_id_UNIQUE", columns={"commentID"})}
 *     )
 * @ORM\Entity
 */
class BlogComments
{
    /**
     * Unique comment ID.
     *
     * @var integer
     *
     * @ORM\Column(name="commentID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $commentid;

    /**
     * ID of the post this comment is on.
     *
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="BlogPosts", inversedBy="comments")
     * @ORM\JoinColumn(name="postid", referencedColumnName="postID")
     */
    private $postid;

    /**
     * Comment posted by name.
     *
     * @var string
     *
     * @ORM\Column(name="commentUsername", type="string", length=100, nullable=false)
     */
    private $commentusername;

    /**
     * Comment content.
     *
     * @var string
     *
     * @ORM\Column(name="commentText", type="string", length=4000, nullable=false)
     */
    private $commenttext;

    /**
     * Comment timestamp.
     *
     * @var integer
     *
     * @ORM\Column(name="commentTimestamp", type="integer", nullable=false)
     */
    private $commenttimestamp;

    /**
     * Posters IP address.
     *
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
    public function getCommentId()
    {
        return $this->commentid;
    }

    /**
     * Set postid
     *
     * @param integer $postId Post ID.
     *
     * @return BlogComments
     */
    public function setPostId($postId)
    {
        $this->postid = $postId;

        return $this;
    }

    /**
     * Get postid
     *
     * @return integer
     */
    public function getPostId()
    {
        return $this->postid;
    }

    /**
     * Set comment username
     *
     * @param string $commentUsername Username.
     *
     * @return BlogComments
     */
    public function setCommentUsername($commentUsername)
    {
        $this->commentusername = $commentUsername;

        return $this;
    }

    /**
     * Get comment username.
     *
     * @return string
     */
    public function getCommentUsername()
    {
        return $this->commentusername;
    }

    /**
     * Set comment text
     *
     * @param string $commentText Comment content.
     *
     * @return BlogComments
     */
    public function setCommentText($commentText)
    {
        $this->commenttext = $commentText;

        return $this;
    }

    /**
     * Get comment text.
     *
     * @return string
     */
    public function getCommentText()
    {
        return $this->commenttext;
    }

    /**
     * Set comment timestamp
     *
     * @param integer $commentTimestamp Timestamp.
     *
     * @return BlogComments
     */
    public function setCommentTimestamp($commentTimestamp)
    {
        $this->commenttimestamp = $commentTimestamp;

        return $this;
    }

    /**
     * Get comment timestamp
     *
     * @return integer
     */
    public function getCommentTimestamp()
    {
        return $this->commenttimestamp;
    }

    /**
     * Set clientip
     *
     * @param string $clientIp IP address.
     *
     * @return BlogComments
     */
    public function setClientIp($clientIp)
    {
        $this->clientip = $clientIp;

        return $this;
    }

    /**
     * Get client ip
     *
     * @return string
     */
    public function getClientIp()
    {
        return $this->clientip;
    }
}
