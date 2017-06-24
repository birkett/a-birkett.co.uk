<?php

namespace WebsiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SiteTweets
 *
 * @ORM\Table(name="site_tweets", uniqueConstraints={@ORM\UniqueConstraint(name="tweet_id_UNIQUE", columns={"tweetID"})})
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
    private $tweetid;

    /**
     * @var integer
     *
     * @ORM\Column(name="tweetTimestamp", type="integer", nullable=false)
     */
    private $tweettimestamp;

    /**
     * @var string
     *
     * @ORM\Column(name="tweetText", type="string", length=560, nullable=false)
     */
    private $tweettext;

    /**
     * @var string
     *
     * @ORM\Column(name="tweetAvatar", type="string", length=1000, nullable=false)
     */
    private $tweetavatar;

    /**
     * @var string
     *
     * @ORM\Column(name="tweetName", type="string", length=100, nullable=false)
     */
    private $tweetname;

    /**
     * @var string
     *
     * @ORM\Column(name="tweetScreenname", type="string", length=60, nullable=false)
     */
    private $tweetscreenname;

    /**
     * @var integer
     *
     * @ORM\Column(name="tweetFetchTime", type="integer", nullable=false)
     */
    private $tweetfetchtime;



    /**
     * Get tweetid
     *
     * @return string
     */
    public function getTweetid()
    {
        return $this->tweetid;
    }

    /**
     * Set tweettimestamp
     *
     * @param integer $tweettimestamp
     *
     * @return SiteTweets
     */
    public function setTweettimestamp($tweettimestamp)
    {
        $this->tweettimestamp = $tweettimestamp;

        return $this;
    }

    /**
     * Get tweettimestamp
     *
     * @return integer
     */
    public function getTweettimestamp()
    {
        return $this->tweettimestamp;
    }

    /**
     * Set tweettext
     *
     * @param string $tweettext
     *
     * @return SiteTweets
     */
    public function setTweettext($tweettext)
    {
        $this->tweettext = $tweettext;

        return $this;
    }

    /**
     * Get tweettext
     *
     * @return string
     */
    public function getTweettext()
    {
        return $this->tweettext;
    }

    /**
     * Set tweetavatar
     *
     * @param string $tweetavatar
     *
     * @return SiteTweets
     */
    public function setTweetavatar($tweetavatar)
    {
        $this->tweetavatar = $tweetavatar;

        return $this;
    }

    /**
     * Get tweetavatar
     *
     * @return string
     */
    public function getTweetavatar()
    {
        return $this->tweetavatar;
    }

    /**
     * Set tweetname
     *
     * @param string $tweetname
     *
     * @return SiteTweets
     */
    public function setTweetname($tweetname)
    {
        $this->tweetname = $tweetname;

        return $this;
    }

    /**
     * Get tweetname
     *
     * @return string
     */
    public function getTweetname()
    {
        return $this->tweetname;
    }

    /**
     * Set tweetscreenname
     *
     * @param string $tweetscreenname
     *
     * @return SiteTweets
     */
    public function setTweetscreenname($tweetscreenname)
    {
        $this->tweetscreenname = $tweetscreenname;

        return $this;
    }

    /**
     * Get tweetscreenname
     *
     * @return string
     */
    public function getTweetscreenname()
    {
        return $this->tweetscreenname;
    }

    /**
     * Set tweetfetchtime
     *
     * @param integer $tweetfetchtime
     *
     * @return SiteTweets
     */
    public function setTweetfetchtime($tweetfetchtime)
    {
        $this->tweetfetchtime = $tweetfetchtime;

        return $this;
    }

    /**
     * Get tweetfetchtime
     *
     * @return integer
     */
    public function getTweetfetchtime()
    {
        return $this->tweetfetchtime;
    }
}
