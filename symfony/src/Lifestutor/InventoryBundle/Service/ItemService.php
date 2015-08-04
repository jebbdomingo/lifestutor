<?php

namespace Lifestutor\InventoryBundle\Service;

class ItemService
{
    /**
     * Document manager.
     */
    private $dm;

    /**
     * Item repository.
     */
    private $itemRepository;

    /**
     * Catalog repository.
     */
    private $catalogRepository;

    /**
     * Item class.
     */
    private $itemClass;

    /**
     * Catalog class.
     */
    private $catalogClass;

    /**
     * Constructor
     * 
     * @param doctrine $doctrine_mongodb
     * @param string   $itemClass
     * @param string   $catalogClass
     */
    public function __construct($doctrine_mongodb, $itemClass, $catalogClass)
    {
        $this->dm                = $doctrine_mongodb->getManager();
        $this->itemClass         = $itemClass;
        $this->itemRepository    = $doctrine_mongodb->getRepository($itemClass);
        $this->catalogRepository = $doctrine_mongodb->getRepository($catalogClass);
    }

    /**
     * Get specific item by id.
     *
     * @param mixded $id
     *
     * @return UserInterface
     */
    public function get($id)
    {
        return $this->itemRepository->find($id);
    }

    /**
     * Get items by catalog.
     *
     * @param string  $catalog_id
     * @param integer $limit      The limit of the result.
     * @param integer $offset     Starting from the offset.
     *
     * @return array
     */
    public function getItemsByCatalog($catalog_id, $limit = 5, $offset = 0)
    {
        $catalog = $this->catalogRepository->find($catalog_id);

        return $this->dm->createQueryBuilder($this->itemClass)
                        ->field('catalogs')
                        ->references($catalog)
                        ->getQuery()
                        ->execute();
    }
}