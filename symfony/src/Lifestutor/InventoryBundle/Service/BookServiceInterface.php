<?php

namespace Lifestutor\InventoryBundle\Service;

interface BookServiceInterface
{
    /**
     * Get a book with its id.
     *
     * @param string $id
     */
    public function get($id);

    /**
     * Get list of book items
     *
     * @param integer $limit  The limit of the result.
     * @param integer $offset Starting from the offset.
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0);

    /**
     * Creates a new Book item.
     *
     * @param array $parameters
     */
    public function post(array $parameters);
}