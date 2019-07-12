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
use Symfony\Component\Security\Core\User\UserInterface;
use Serializable;

/**
 * User
 *
 * @ORM\Table(name="tblUser", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="UK_intUserId", columns={"intUserId"}),
 *     @ORM\UniqueConstraint(name="UK_strUsername", columns={"strUsername"})
 * })
 * @ORM\Entity
 */
class User implements UserInterface, Serializable
{
    /**
     * User ID.
     *
     * @var integer
     *
     * @ORM\Column(name="intUserId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Username.
     *
     * @var string
     *
     * @ORM\Column(name="strUsername", type="string", length=45, nullable=false)
     */
    private $username;

    /**
     * Hashed password.
     *
     * @var string
     *
     * @ORM\Column(name="strPassword", type="string", length=512, nullable=false)
     */
    private $password;


    /**
     * Get the user ID.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }//end getId()


    /**
     * Set the username.
     *
     * @param string $username Username.
     *
     * @return User
     */
    public function setUsername(string $username): User
    {
        $this->username = $username;

        return $this;
    }//end setUsername()


    /**
     * Get username.
     *
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }//end getUsername()


    /**
     * Set password.
     *
     * @param string $password Password.
     *
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;

        return $this;
    }//end setPassword()


    /**
     * Get password.
     *
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }//end getPassword()


    /**
     * Gets the password salt. Null when using bcrypt.
     *
     * @return void
     */
    public function getSalt(): void
    {
    }//end getSalt()


    /**
     * Get the users associated roles.
     *
     * @return array
     */
    public function getRoles(): array
    {
        return ['ROLE_ADMIN'];
    }//end getRoles()


    /**
     * Remove old credentials.
     *
     * @return void
     */
    public function eraseCredentials(): void
    {
    }//end eraseCredentials()


    /**
     * Serialize the entity.
     *
     * @return string
     */
    public function serialize(): string
    {
        return serialize([$this->id, $this->username, $this->password]);
    }//end serialize()


    /**
     * Deserialize the entity.
     *
     * @param string $serialized Serialized entity.
     *
     * @return void
     */
    public function unserialize($serialized): void
    {
        [
            $this->id,
            $this->username,
            $this->password,
        ] = unserialize(
            $serialized,
            ['allowed_classes' => [self::class]]
        );
    }//end unserialize()
}//end class
