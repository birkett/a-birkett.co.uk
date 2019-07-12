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

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * BlockedAddress
 *
 * @ORM\Table(name="tblBlockedAddress", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="UK_intBlockedAddressId", columns={"intBlockedAddressId"}),
 *     @ORM\UniqueConstraint(name="UK_strAddress",          columns={"strAddress"}),
 * })
 * @ORM\Entity
 */
class BlockedAddress
{
    /**
     * Blocked address ID.
     *
     * @var integer
     *
     * @ORM\Column(name="intBlockedAddressId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * IP Address.
     *
     * @var string
     *
     * @ORM\Column(name="strAddress", type="string", length=180, nullable=false)
     */
    private $address;

    /**
     * Blocked time.
     *
     * @var DateTime
     *
     * @ORM\Column(name="dtmTimestamp", type="datetime", nullable=false)
     */
    private $timestamp;


    /**
     * BlockedAddress constructor.
     */
    public function __construct()
    {
        $this->timestamp = new DateTime();
    }//end __construct()


    /**
     * Get the blocked address ID.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }//end getId()


    /**
     * Set the IP Address.
     *
     * @param string $address IP Address.
     *
     * @return BlockedAddress
     */
    public function setAddress(string $address): BlockedAddress
    {
        $this->address = $address;

        return $this;
    }//end setAddress()


    /**
     * Get address.
     *
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }//end getAddress()


    /**
     * Set timestamp.
     *
     * @param DateTime $timestamp Timestamp.
     *
     * @return BlockedAddress
     */
    public function setTimestamp(DateTime $timestamp): BlockedAddress
    {
        $this->timestamp = $timestamp;

        return $this;
    }//end setTimestamp()


    /**
     * Get timestamp.
     *
     * @return DateTime
     */
    public function getTimestamp(): DateTime
    {
        return $this->timestamp;
    }//end getTimestamp()
}//end class
