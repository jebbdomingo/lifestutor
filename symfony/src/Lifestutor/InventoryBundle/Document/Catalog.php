<?php

namespace Lifestutor\InventoryBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @MongoDB\Document
 * @MongoDB\Index(unique=true, order="asc")
 * @ExclusionPolicy("all")
 */
class Catalog
{
    /**
     * @MongoDB\ReferenceMany(targetDocument="Item", mappedBy="catalogs")
     */
    private $items;

    /**
     * @MongoDB\Id
     * @Expose
     */
    protected $id;

    /**
     * @MongoDB\String
     * @Assert\NotBlank()
     * @Expose
     */
    protected $name;

    /**
     * @MongoDB\Boolean
     * @Expose
     */
    protected $published;

    /**
     * Constructor
     */
    public function __construct($name)
    {
        $this->setName($name);
        
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set published
     *
     * @param boolean $published
     * @return self
     */
    public function publish($published)
    {
        $this->published = $published;
        return $this;
    }

    /**
     * Is published
     *
     * @return boolean $published
     */
    public function isPublished()
    {
        return $this->published;
    }
}