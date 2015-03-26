<?php

namespace Lifestutor\InventoryBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @MongoDB\Document
 */
class Food extends Item
{
    /**
     * @MongoDB\String
     * @Expose
     */
    protected $itemType = 'Food';
}