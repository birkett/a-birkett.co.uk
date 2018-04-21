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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Post
 *
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 * @ORM\Table(name="tblPost", uniqueConstraints={@ORM\UniqueConstraint(name="UK_intPostId", columns={"intPostId"})})
 */
class Post
{
    /**
     * Post ID.
     *
     * @var integer
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="intPostId", type="integer", nullable=false)
     */
    private $postId;

    /**
     * Post time stamp.
     *
     * @var \DateTime
     *
     * @ORM\Column(name="dtmTimestamp", type="datetime", nullable=false)
     */
    private $postTimestamp;

    /**
     * Post title.
     *
     * @var string
     *
     * @ORM\Column(name="strTitle", type="string", length=280, nullable=false)
     */
    private $postTitle;

    /**
     * Post content.
     *
     * @var string
     *
     * @ORM\Column(name="strContent", type="text", length=65535, nullable=false)
     */
    private $postContent;

    /**
     * Post draft status.
     *
     * @var boolean
     *
     * @ORM\Column(name="bolDraft", type="boolean", nullable=false)
     */
    private $postDraft;

    /**
     * Post tweeted status.
     *
     * @var boolean
     *
     * @ORM\Column(name="bolTweeted", type="boolean", nullable=false)
     */
    private $postTweeted;

    /**
     * ArrayCollection of comments attached to this post.
     *
     * @var Comment[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="post")
     */
    private $comments;


    /**
     * Post constructor.
     */
    public function __construct()
    {
        $this->postTimestamp = new \DateTime();
        $this->postDraft     = true;
        $this->postTweeted   = true;
    }//end __construct()


    /**
     * Get postId.
     *
     * @return int|null
     */
    public function getPostId(): ?int
    {
        return $this->postId;
    }//end getPostId()


    /**
     * Set postTimestamp.
     *
     * @param \DateTime $postTimestamp Timestamp.
     *
     * @return Post
     */
    public function setPostTimestamp(\DateTime $postTimestamp): Post
    {
        $this->postTimestamp = $postTimestamp;

        return $this;
    }//end setPostTimestamp()


    /**
     * Get postTimestamp.
     *
     * @return \DateTime|null
     */
    public function getPostTimestamp(): ?\DateTime
    {
        return $this->postTimestamp;
    }//end getPostTimestamp()


    /**
     * Set postTitle.
     *
     * @param string $postTitle Title.
     *
     * @return Post
     */
    public function setPostTitle(string $postTitle): Post
    {
        $this->postTitle = $postTitle;

        return $this;
    }//end setPostTitle()


    /**
     * Get postTitle
     *
     * @return string|null
     */
    public function getPostTitle(): ?string
    {
        return $this->postTitle;
    }//end getPostTitle()


    /**
     * Set postContent.
     *
     * @param string $postContent Content.
     *
     * @return Post
     */
    public function setPostContent(string $postContent): Post
    {
        $this->postContent = $postContent;

        return $this;
    }//end setPostContent()


    /**
     * Get postContent.
     *
     * @return string|null
     */
    public function getPostContent(): ?string
    {
        return $this->postContent;
    }//end getPostContent()


    /**
     * Set postDraft.
     *
     * @param bool $postDraft Draft status.
     *
     * @return Post
     */
    public function setPostDraft(bool $postDraft): Post
    {
        $this->postDraft = $postDraft;

        return $this;
    }//end setPostDraft()


    /**
     * Get postDraft.
     *
     * @return bool
     */
    public function getPostDraft(): bool
    {
        return $this->postDraft;
    }//end getPostDraft()


    /**
     * Set postTweeted.
     *
     * @param bool $postTweeted Tweeted status.
     *
     * @return Post
     */
    public function setPostTweeted(bool $postTweeted): Post
    {
        $this->postTweeted = $postTweeted;

        return $this;
    }//end setPostTweeted()


    /**
     * Get postTweeted.
     *
     * @return bool
     */
    public function getPostTweeted(): bool
    {
        return $this->postTweeted;
    }//end getPostTweeted()


    /**
     * Get comments.
     *
     * @return Comment[]|ArrayCollection
     */
    public function getComments()
    {
        return $this->comments;
    }//end getComments()


    /**
     * Get the number of comments on a post.
     *
     * @return int
     */
    public function getCommentsCount(): int
    {
        return count($this->comments);
    }//end getCommentsCount()


    /**
     * Add comment.
     *
     * @param Comment $comment Comment.
     *
     * @return Post
     */
    public function addComment(Comment $comment): Post
    {
        $this->comments[] = $comment;

        return $this;
    }//end addComment()


    /**
     * Return the post title when treated as a string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->postTitle;
    }//end __toString()
}//end class
