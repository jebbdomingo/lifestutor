<?php

namespace Lifestutor\InventoryBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @MongoDB\Document
 * @MongoDB\Index(unique=true, order="asc")
 * @ExclusionPolicy("all")
 * @Serializer\XmlRoot("catalog")
 * @Hateoas\Relation("self", href = "expr('/api/v1/catalogs/' ~ object.getId())")
 */
class Catalog
{

    /**
     * @MongoDB\ReferenceMany(targetDocument="Item", mappedBy="catalogs")
     */
    protected $items;

    /**
     * @MongoDB\Id
     * @Expose
     * @Groups({"inventory", "storefront"})
     */
    protected $id;

    /**
     * @MongoDB\String
     * @Assert\NotBlank()
     * @Expose
     * @Groups({"inventory", "storefront"})
     */
    protected $name;

    /**
     * @MongoDB\Boolean
     * @Expose
     * @Groups({"inventory"})
     */
    protected $published;

    /**
     * Constructor
     */
    public function __construct($name)
    {
        $this->items = new ArrayCollection();
        $this->setName($name);
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