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
 * Tweet
 *
 * @ORM\Table(name="tblTweet", uniqueConstraints={@ORM\UniqueConstraint(name="UK_intTweetId", columns={"intTweetId"})})
 * @ORM\Entity
 */
class Tweet
{
    /**
     * Tweet ID.
     *
     * @var string
     *
     * @ORM\Column(name="intTweetId", type="string", length=100, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $tweetId;

    /**
     * Tweet timestamp.
     *
     * @var \DateTime
     *
     * @ORM\Column(name="dtmTimestamp", type="datetime", nullable=false)
     */
    private $tweetTimestamp;

    /**
     * Tweet text.
     *
     * @var string
     *
     * @ORM\Column(name="strContent", type="string", length=560, nullable=false)
     */
    private $tweetText;

    /**
     * Tweet avatar.
     *
     * @var string
     *
     * @ORM\Column(name="strAvatar", type="string", length=1000, nullable=false)
     */
    private $tweetAvatar;

    /**
     * Tweet name.
     *
     * @var string
     *
     * @ORM\Column(name="strName", type="string", length=100, nullable=false)
     */
    private $tweetName;

    /**
     * Tweet screen name.
     *
     * @var string
     *
     * @ORM\Column(name="strScreenName", type="string", length=60, nullable=false)
     */
    private $tweetScreenName;

    /**
     * Tweet fetch timestamp.
     *
     * @var \DateTime
     *
     * @ORM\Column(name="dtmFetchTimestamp", type="datetime", nullable=false)
     */
    private $tweetFetchTime;


    /**
     * Get tweetId.
     *
     * @return string|null
     */
    public function getTweetId(): ?string
    {
        return $this->tweetId;
    }//end getTweetId()


    /**
     * Set tweetTimestamp.
     *
     * @param \DateTime $tweetTimestamp Tweet timestamp.
     *
     * @return Tweet
     */
    public function setTweetTimestamp(\DateTime $tweetTimestamp): Tweet
    {
        $this->tweetTimestamp = $tweetTimestamp;

        return $this;
    }//end setTweetTimestamp()


    /**
     * Get tweetTimestamp.
     *
     * @return \DateTime|null
     */
    public function getTweetTimestamp(): ?\DateTime
    {
        return $this->tweetTimestamp;
    }//end getTweetTimestamp()


    /**
     * Set tweetText.
     *
     * @param string $tweetText Tweet text.
     *
     * @return Tweet
     */
    public function setTweetText(string $tweetText): Tweet
    {
        $this->tweetText = $tweetText;

        return $this;
    }//end setTweetText()


    /**
     * Get tweetText.
     *
     * @return string|null
     */
    public function getTweetText(): ?string
    {
        return $this->tweetText;
    }//end getTweetText()


    /**
     * Set tweetAvatar.
     *
     * @param string $tweetAvatar Tweet avatar.
     *
     * @return Tweet
     */
    public function setTweetAvatar(string $tweetAvatar): Tweet
    {
        $this->tweetAvatar = $tweetAvatar;

        return $this;
    }//end setTweetAvatar()


    /**
     * Get tweetAvatar.
     *
     * @return string|null
     */
    public function getTweetAvatar(): ?string
    {
        return $this->tweetAvatar;
    }//end getTweetAvatar()


    /**
     * Set tweetName.
     *
     * @param string $tweetName Tweet name.
     *
     * @return Tweet
     */
    public function setTweetName(string $tweetName): Tweet
    {
        $this->tweetName = $tweetName;

        return $this;
    }//end setTweetName()


    /**
     * Get tweetName.
     *
     * @return string|null
     */
    public function getTweetName(): ?string
    {
        return $this->tweetName;
    }//end getTweetName()


    /**
     * Set tweetScreenName.
     *
     * @param string $tweetScreenName Tweet screen name.
     *
     * @return Tweet
     */
    public function setTweetScreenName(string $tweetScreenName): Tweet
    {
        $this->tweetScreenName = $tweetScreenName;

        return $this;
    }//end setTweetScreenName()


    /**
     * Get tweetScreenName.
     *
     * @return string|null
     */
    public function getTweetScreenName(): ?string
    {
        return $this->tweetScreenName;
    }//end getTweetScreenName()


    /**
     * Set tweetFetchTime.
     *
     * @param \DateTime $tweetFetchTime Tweet fetch timestamp.
     *
     * @return Tweet
     */
    public function setTweetFetchTime(\DateTime $tweetFetchTime): Tweet
    {
        $this->tweetFetchTime = $tweetFetchTime;

        return $this;
    }//end setTweetFetchTime()


    /**
     * Get tweetFetchTime.
     *
     * @return \DateTime|null
     */
    public function getTweetFetchTime(): ?\DateTime
    {
        return $this->tweetFetchTime;
    }//end getTweetFetchTime()
}//end class
