<?php

namespace Lifestutor\StoreBundle\Service;

use Lifestutor\StoreBundle\Document\Item;

interface ItemServiceInterface
{
    /**
     * Get a user with its id.
     *
     * @param string $id
     *
     * @return Item
     */
    //public function get($id);

    /**
     * Get list of users
     *
     * @param integer $limit  The limit of the result.
     * @param integer $offset Starting from the offset.
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0);

    /**
     * Post User, creates a new User.
     *
     * @api
     *
     * @param array $parameters
     *
     * @return Item
     */
    //public function post(array $parameters);
}