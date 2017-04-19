<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(name="public", type="boolean")
     */
    private $public;

    /**
     * @ORM\Column(name="frozen", type="boolean")
     */
    private $frozen;

    //=====================================================

    /**
     * @ORM\OneToMany(targetEntity="Nurl", mappedBy="author_id")
     */
    private $nurls;

    /**
     * @ORM\OneToMany(targetEntity="NurlCollection", mappedBy="owned_by")
     */
    private $collections;

    public function __construct()
    {
        $this->isActive = true;
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid(null, true));
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getSalt()
    {
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @ORM\Column(type="json_array")
     */
    private $roles = [];

    public function getRoles()
    {
        $roles = $this->roles;

        return array_unique($roles);
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
        return $this;
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            ) = unserialize($serialized);
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set public
     *
     * @param boolean $public
     *
     * @return User
     */
    public function setPublic($public)
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Get public
     *
     * @return boolean
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * Set frozen
     *
     * @param boolean $frozen
     *
     * @return User
     */
    public function setFrozen($frozen)
    {
        $this->frozen = $frozen;

        return $this;
    }

    /**
     * Get frozen
     *
     * @return boolean
     */
    public function getFrozen()
    {
        return $this->frozen;
    }

    /**
     * Add nurl
     *
     * @param \AppBundle\Entity\Nurl $nurl
     *
     * @return User
     */
    public function addNurl(\AppBundle\Entity\Nurl $nurl)
    {
        $this->nurls[] = $nurl;

        return $this;
    }

    /**
     * Remove nurl
     *
     * @param \AppBundle\Entity\Nurl $nurl
     */
    public function removeNurl(\AppBundle\Entity\Nurl $nurl)
    {
        $this->nurls->removeElement($nurl);
    }

    /**
     * Get nurls
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNurls()
    {
        return $this->nurls;
    }

    /**
     * Add collection
     *
     * @param \AppBundle\Entity\NurlCollection $collection
     *
     * @return User
     */
    public function addCollection(\AppBundle\Entity\NurlCollection $collection)
    {
        $this->collections[] = $collection;

        return $this;
    }

    /**
     * Remove collection
     *
     * @param \AppBundle\Entity\NurlCollection $collection
     */
    public function removeCollection(\AppBundle\Entity\NurlCollection $collection)
    {
        $this->collections->removeElement($collection);
    }

    /**
     * Get collections
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCollections()
    {
        return $this->collections;
    }
}
