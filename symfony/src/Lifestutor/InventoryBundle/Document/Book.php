<?php

namespace Lifestutor\InventoryBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Book extends Item
{
    /**
     * @MongoDB\String
     */
    protected $itemType = 'Book';
}