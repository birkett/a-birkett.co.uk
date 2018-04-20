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
 * Comment
 *
 * @ORM\Table(
 *     name="tblComment",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="UK_intCommentId", columns={"intCommentId"})}
 *     )
 * @ORM\Entity
 */
class Comment
{
    /**
     * Unique comment ID.
     *
     * @var int
     *
     * @ORM\Column(name="intCommentId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $commentId;

    /**
     * Post this comment is on.
     *
     * @var Post
     *
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="comments")
     * @ORM\JoinColumn(name="intPostId", referencedColumnName="intPostId")
     */
    private $post;

    /**
     * Comment posted by name.
     *
     * @var string
     *
     * @ORM\Column(name="strUsername", type="string", length=100, nullable=false)
     */
    private $commentUsername;

    /**
     * Comment content.
     *
     * @var string
     *
     * @ORM\Column(name="strContent", type="string", length=4000, nullable=false)
     */
    private $commentText;

    /**
     * Comment timestamp.
     *
     * @var \DateTime
     *
     * @ORM\Column(name="dtmTimestamp", type="datetime", nullable=false)
     */
    private $commentTimestamp;

    /**
     * Posters IP address.
     *
     * @var string
     *
     * @ORM\Column(name="strClientIp", type="string", length=180, nullable=false)
     */
    private $clientIp;

    /**
     * Comment constructor.
     */
    public function __construct()
    {
        $this->setCommentTimestamp(new \DateTime());
    }

    /**
     * Get commentid
     *
     * @return int|null
     */
    public function getCommentId(): ?int
    {
        return $this->commentId;
    }

    /**
     * Set postid
     *
     * @param Post $post Post.
     *
     * @return Comment
     */
    public function setPost(Post $post): Comment
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return Post|null
     */
    public function getPost(): ?Post
    {
        return $this->post;
    }

    /**
     * Set comment username
     *
     * @param string $commentUsername Username.
     *
     * @return Comment
     */
    public function setCommentUsername(string $commentUsername): Comment
    {
        $this->commentUsername = $commentUsername;

        return $this;
    }

    /**
     * Get comment username.
     *
     * @return string|null
     */
    public function getCommentUsername(): ?string
    {
        return $this->commentUsername;
    }

    /**
     * Set comment text
     *
     * @param string $commentText Comment content.
     *
     * @return Comment
     */
    public function setCommentText(string $commentText): Comment
    {
        $this->commentText = $commentText;

        return $this;
    }

    /**
     * Get comment text.
     *
     * @return string|null
     */
    public function getCommentText(): ?string
    {
        return $this->commentText;
    }

    /**
     * Set comment timestamp
     *
     * @param \DateTime $commentTimestamp Timestamp.
     *
     * @return Comment
     */
    public function setCommentTimestamp(\DateTime $commentTimestamp): Comment
    {
        $this->commentTimestamp = $commentTimestamp;

        return $this;
    }

    /**
     * Get comment timestamp
     *
     * @return \DateTime|null
     */
    public function getCommentTimestamp(): ?\DateTime
    {
        return $this->commentTimestamp;
    }

    /**
     * Set clientip
     *
     * @param string $clientIp IP address.
     *
     * @return Comment
     */
    public function setClientIp(string $clientIp): Comment
    {
        $this->clientIp = $clientIp;

        return $this;
    }

    /**
     * Get client ip
     *
     * @return string|null
     */
    public function getClientIp(): ?string
    {
        return $this->clientIp;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return sprintf(
            '%d-%s-%d',
            $this->commentId,
            $this->commentUsername,
            $this->commentTimestamp->format('Y-m-d H:i:s')
        );
    }
}
