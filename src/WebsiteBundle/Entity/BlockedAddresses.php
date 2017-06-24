<?php

namespace WebsiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BlockedAddresses
 *
 * @ORM\Table(name="blocked_addresses", uniqueConstraints={@ORM\UniqueConstraint(name="address_UNIQUE", columns={"address"})})
 * @ORM\Entity
 */
class BlockedAddresses
{
    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=180, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $address;

    /**
     * @var integer
     *
     * @ORM\Column(name="timestamp", type="integer", nullable=false)
     */
    private $timestamp;



    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set timestamp
     *
     * @param integer $timestamp
     *
     * @return BlockedAddresses
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return integer
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }
}
