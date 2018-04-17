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

namespace WebsiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SiteTweets
 *
 * @ORM\Table(
 *     name="site_tweets",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="tweet_id_UNIQUE", columns={"tweetID"})}
 *     )
 * @ORM\Entity
 */
class SiteTweets
{
    /**
     * @var string
     *
     * @ORM\Column(name="tweetID", type="string", length=100, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $tweetId;

    /**
     * @var int
     *
     * @ORM\Column(name="tweetTimestamp", type="integer", nullable=false)
     */
    private $tweetTimestamp;

    /**
     * @var string
     *
     * @ORM\Column(name="tweetText", type="string", length=560, nullable=false)
     */
    private $tweetText;

    /**
     * @var string
     *
     * @ORM\Column(name="tweetAvatar", type="string", length=1000, nullable=false)
     */
    private $tweetAvatar;

    /**
     * @var string
     *
     * @ORM\Column(name="tweetName", type="string", length=100, nullable=false)
     */
    private $tweetName;

    /**
     * @var string
     *
     * @ORM\Column(name="tweetScreenname", type="string", length=60, nullable=false)
     */
    private $tweetScreenName;

    /**
     * @var int
     *
     * @ORM\Column(name="tweetFetchTime", type="integer", nullable=false)
     */
    private $tweetFetchTime;

    /**
     * Get tweetId
     *
     * @return string
     */
    public function getTweetId(): string
    {
        return $this->tweetId;
    }

    /**
     * Set tweetTimestamp
     *
     * @param integer $tweetTimestamp
     *
     * @return SiteTweets
     */
    public function setTweetTimestamp($tweetTimestamp): SiteTweets
    {
        $this->tweetTimestamp = $tweetTimestamp;

        return $this;
    }

    /**
     * Get tweetTimestamp
     *
     * @return int
     */
    public function getTweetTimestamp(): int
    {
        return $this->tweetTimestamp;
    }

    /**
     * Set tweetText
     *
     * @param string $tweetText
     *
     * @return SiteTweets
     */
    public function setTweetText($tweetText): SiteTweets
    {
        $this->tweetText = $tweetText;

        return $this;
    }

    /**
     * Get tweetText
     *
     * @return string
     */
    public function getTweetText(): string
    {
        return $this->tweetText;
    }

    /**
     * Set tweetAvatar
     *
     * @param string $tweetAvatar
     *
     * @return SiteTweets
     */
    public function setTweetAvatar($tweetAvatar): SiteTweets
    {
        $this->tweetAvatar = $tweetAvatar;

        return $this;
    }

    /**
     * Get tweetAvatar
     *
     * @return string
     */
    public function getTweetAvatar(): string
    {
        return $this->tweetAvatar;
    }

    /**
     * Set tweetName
     *
     * @param string $tweetName
     *
     * @return SiteTweets
     */
    public function setTweetName($tweetName): SiteTweets
    {
        $this->tweetName = $tweetName;

        return $this;
    }

    /**
     * Get tweetName
     *
     * @return string
     */
    public function getTweetName(): string
    {
        return $this->tweetName;
    }

    /**
     * Set tweetScreenName
     *
     * @param string $tweetScreenName
     *
     * @return SiteTweets
     */
    public function setTweetScreenName($tweetScreenName): SiteTweets
    {
        $this->tweetScreenName = $tweetScreenName;

        return $this;
    }

    /**
     * Get tweetScreenName
     *
     * @return string
     */
    public function getTweetScreenName(): string
    {
        return $this->tweetScreenName;
    }

    /**
     * Set tweetFetchTime
     *
     * @param integer $tweetFetchTime
     *
     * @return SiteTweets
     */
    public function setTweetFetchTime($tweetFetchTime): SiteTweets
    {
        $this->tweetFetchTime = $tweetFetchTime;

        return $this;
    }

    /**
     * Get tweetFetchTime
     *
     * @return int
     */
    public function getTweetFetchTime(): int
    {
        return $this->tweetFetchTime;
    }
}
