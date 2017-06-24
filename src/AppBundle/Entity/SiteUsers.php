<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * SiteUsers
 *
 * @ORM\Table(name="site_users", uniqueConstraints={@ORM\UniqueConstraint(name="username_UNIQUE", columns={"username"})})
 * @ORM\Entity
 */
class SiteUsers implements UserInterface, \Serializable
{
    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=45, nullable=false)
     * @ORM\Id
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=512, nullable=false)
     */
    private $password;



    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return SiteUsers
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Gets the password salt. Null when using bcrypt
     *
     * @return null
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Get the users associated roles
     *
     * @return array
     */
    public function getRoles()
    {
        return array('ROLE_ADMIN');
    }

    /**
     * Remove old credentials
     */
    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->username,
            $this->password,
        ));
    }

    /**
     * @param string $serialized
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->username,
            $this->password,
            ) = unserialize($serialized);
    }
}
