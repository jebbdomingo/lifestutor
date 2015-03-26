<?php

namespace Lifestutor\StoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\EmbeddedDocument 
 */
class Cart
{
    /**
     * array(
     *     [itemId] => array(
     *                     'item'     => Lifestutor\InventoryBundle\Document\Item,
     *                     'quantity' => 3
     *                 )
     * )
     */
    private $items = array();

    /**
     * Add item
     *
     * @param Lifestutor\InventoryBundle\Document\Item
     * @param integer $quantity
     *
     * @return $this
     */
    public function addItem($item, $quantity)
    {
        $this->addUpdateQuantity($item, $quantity);

        return $this;
    }

    /**
     * Add item and update quantity if the item already exists in the cart
     *
     * @param Lifestutor\InventoryBundle\Document\Item
     * @param integer $quantity
     *
     * @return void
     */
    private function addUpdateQuantity($item, $quantity)
    {
        if (array_key_exists($item->getId(), $this->items)) {
            $this->items[$item->getId()]['quantity'] = $this->items[$item->getId()]['quantity'] + $quantity;
        } else {
            $this->items[$item->getId()]['item']     = $item;
            $this->items[$item->getId()]['quantity'] = $quantity;
        }
    }
}