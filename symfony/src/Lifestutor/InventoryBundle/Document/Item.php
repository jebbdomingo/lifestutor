<?php

namespace Lifestutor\InventoryBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
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
 *
 * @MongoDB\InheritanceType("SINGLE_COLLECTION")
 * @MongoDB\DiscriminatorField("type")
 * @MongoDB\DiscriminatorMap({"item"="Item", "book"="Book", "food"="Food"})
 */
class Item
{
    /**
     * @MongoDB\ReferenceMany(targetDocument="Catalog", inversedBy="items")
     */
    private $catalogs;

    /**
     * @MongoDB\Id
     * @Expose
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $itemType = 'Item';

    /**
     * @MongoDB\String
     * @Assert\NotBlank()
     * @Expose
     * @Groups({"inventory", "storefront"})
     */
    protected $name;

    /**
     * @MongoDB\String
     * @Expose
     * @Groups({"inventory", "storefront"})
     */
    protected $code;

    /**
     * @MongoDB\Float
     * @Expose
     * @Groups({"inventory"})
     */
    protected $cost;

    /**
     * @MongoDB\Float
     * @Expose
     * @Groups({"inventory", "storefront"})
     */
    protected $sellingPrice;

    /**
     * @MongoDB\Int
     * @Expose
     * @Groups({"inventory", "storefront"})
     */
    protected $quantity;

    /**
     * @MongoDB\Float
     * @Expose
     * @Groups({"inventory", "storefront"})
     */
    protected $rewardPoint;

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
        $this->setName($name);
        $this->catalogs = new ArrayCollection();
    }

    /**
     * Add catalog
     * 
     * @param Catalog $catalog
     */
    public function addCatalog(Catalog $catalog)
    {
        $this->catalogs[] = $catalog;
    }

    /**
     * Get catalogs
     * 
     * @return ArrayCollection
     */
    public function getCatalogs()
    {
        return $this->catalogs;
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
     * Set itemType
     *
     * @param string $itemType
     * @return self
     */
    public function setItemType($itemType)
    {
        $this->itemType = $itemType;
        return $this;
    }

    /**
     * Get itemType
     *
     * @return string $itemType
     */
    public function getItemType()
    {
        return $this->itemType;
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
     * Set code
     *
     * @param string $code
     * @return self
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Get code
     *
     * @return string $code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set cost
     *
     * @param float $cost
     * @return self
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
        return $this;
    }

    /**
     * Get cost
     *
     * @return float $cost
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set sellingPrice
     *
     * @param float $sellingPrice
     * @return self
     */
    public function setSellingPrice($sellingPrice)
    {
        $this->sellingPrice = $sellingPrice;
        return $this;
    }

    /**
     * Get sellingPrice
     *
     * @return float $sellingPrice
     */
    public function getSellingPrice()
    {
        return $this->sellingPrice;
    }

    /**
     * Set quantity
     *
     * @param int $quantity
     * @return self
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * Get quantity
     *
     * @return int $quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set rewardPoint
     *
     * @param float $rewardPoint
     * @return self
     */
    public function setRewardPoint($rewardPoint)
    {
        $this->rewardPoint = $rewardPoint;
        return $this;
    }

    /**
     * Get rewardPoint
     *
     * @return float $rewardPoint
     */
    public function getRewardPoint()
    {
        return $this->rewardPoint;
    }

    /**
     * Publish
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