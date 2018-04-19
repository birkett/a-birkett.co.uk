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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * BlogPosts
 *
 * @ORM\Entity(repositoryClass="App\Repository\BlogPostsRepository")
 * @ORM\Table(name="blog_posts", uniqueConstraints={@ORM\UniqueConstraint(name="post_id_UNIQUE", columns={"postID"})})
 */
class BlogPosts
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="postID", type="integer", nullable=false)
     */
    private $postId;

    /**
     * @var int
     *
     * @ORM\Column(name="postTimestamp", type="integer", nullable=false)
     */
    private $postTimestamp;

    /**
     * @var string
     *
     * @ORM\Column(name="postTitle", type="string", length=280, nullable=false)
     */
    private $postTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="postContent", type="text", length=65535, nullable=false)
     */
    private $postContent;

    /**
     * @var boolean
     *
     * @ORM\Column(name="postDraft", type="boolean", nullable=false)
     */
    private $postDraft;

    /**
     * @var boolean
     *
     * @ORM\Column(name="postTweeted", type="boolean", nullable=false)
     */
    private $postTweeted;

    /**
     * @var BlogComments[]
     *
     * @ORM\OneToMany(targetEntity="BlogComments", mappedBy="post")
     */
    private $comments;

    /**
     * Get postId
     *
     * @return int
     */
    public function getPostId(): int
    {
        return $this->postId;
    }

    /**
     * Set postTimestamp
     *
     * @param integer $postTimestamp
     *
     * @return BlogPosts
     */
    public function setPostTimestamp($postTimestamp): BlogPosts
    {
        $this->postTimestamp = $postTimestamp;

        return $this;
    }

    /**
     * Get postTimestamp
     *
     * @return int
     */
    public function getPostTimestamp(): int
    {
        return $this->postTimestamp;
    }

    /**
     * Set postTitle
     *
     * @param string $postTitle
     *
     * @return BlogPosts
     */
    public function setPostTitle($postTitle): BlogPosts
    {
        $this->postTitle = $postTitle;

        return $this;
    }

    /**
     * Get postTitle
     *
     * @return string
     */
    public function getPostTitle(): string
    {
        return $this->postTitle;
    }

    /**
     * Set postContent
     *
     * @param string $postContent
     *
     * @return BlogPosts
     */
    public function setPostContent($postContent): BlogPosts
    {
        $this->postContent = $postContent;

        return $this;
    }

    /**
     * Get postContent
     *
     * @return string
     */
    public function getPostContent(): string
    {
        return $this->postContent;
    }

    /**
     * Set postDraft
     *
     * @param boolean $postDraft
     *
     * @return BlogPosts
     */
    public function setPostDraft($postDraft): BlogPosts
    {
        $this->postDraft = $postDraft;

        return $this;
    }

    /**
     * Get postDraft
     *
     * @return bool
     */
    public function getPostDraft(): bool
    {
        return $this->postDraft;
    }

    /**
     * Set postTweeted
     *
     * @param boolean $postTweeted
     *
     * @return BlogPosts
     */
    public function setPostTweeted($postTweeted): BlogPosts
    {
        $this->postTweeted = $postTweeted;

        return $this;
    }

    /**
     * Get postTweeted
     *
     * @return bool
     */
    public function getPostTweeted(): bool
    {
        return $this->postTweeted;
    }

    /**
     * Get comments
     *
     * @return BlogComments[]|array|ArrayCollection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Get the number of comments on a post
     *
     * @return int
     */
    public function getCommentsCount(): int
    {
        return count($this->comments);
    }

    /**
     * Add comment
     *
     * @param BlogComments $comment
     *
     * @return BlogPosts
     */
    public function addComment(BlogComments $comment): BlogPosts
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Return the post title when treated as a string
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->postTitle;
    }
}
