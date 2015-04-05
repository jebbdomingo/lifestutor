<?php

namespace Lifestutor\StoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @MongoDB\Document(collection="users")
 * @MongoDB\Index(unique=true, order="asc")
 * @MongoDBUnique(fields="username")
 * @ExclusionPolicy("all")
 *
 * @MongoDB\InheritanceType("SINGLE_COLLECTION")
 * @MongoDB\DiscriminatorField("type")
 * @MongoDB\DiscriminatorMap({"user"="User", "admin"="Admin", "customer"="Customer"})
 */
class User implements UserInterface, EquatableInterface
{
    /**
     * @MongoDB\Id
     * @Expose
     */
    protected $id;

    /**
     * @MongoDB\String
     * @Expose
     */
    protected $userType = 'User';

    /**
     * @MongoDB\String
     * @MongoDB\UniqueIndex(order="asc")
     * @Assert\NotBlank()
     * @Assert\Email()
     * @Expose
     */
    protected $username;

    /**
     * @MongoDB\String
     * @Assert\NotBlank()
     */
    protected $password;

    /**
     * @MongoDB\String
     */
    private $salt;

    /**
     * @MongoDB\Collection
     */
    private $roles;

    /**
     * @MongoDB\String
     * @Assert\NotBlank()
     * @Expose
     */
    protected $firstname;

    /**
     * @MongoDB\String
     * @Expose
     */
    protected $lastname;

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set roles.
     *
     * @param string $roles
     * @return self
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * [getRoles description]
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set salt.
     *
     * @param string $salt
     * @return self
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
        return $this;
    }

    /**
     * [getSalt description]
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set username.
     *
     * @param string $username
     * @return self
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Get username.
     *
     * @return $username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password.
     *
     * @param string $password
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Get password.
     *
     * @return $password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * [eraseCredentials description]
     * @return [type]
     */
    public function eraseCredentials(){}

    /**
     * [isEqualTo description]
     * @param  UserInterface
     * @return boolean
     */
    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof User) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->salt !== $user->getSalt()) {
            return false;
        }

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }

    /**
     * Set first name.
     *
     * @param string $name
     * @return self
     */
    public function setFirstname($name)
    {
        $this->firstname = $name;
        return $this;
    }

    /**
     * Get first name
     *
     * @return string $firstname
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set last name.
     *
     * @param string $name
     * @return self
     */
    public function setLastname($name)
    {
        $this->lastname = $name;
        return $this;
    }

    /**
     * Get last name
     *
     * @return string $lastname
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Get fullname.
     *
     * @return string
     */
    public function getFullname()
    {
        return $this->firstname . ' ' . $this->lastname;
    }
}