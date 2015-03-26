<?php

namespace Lifestutor\StoreBundle\Service;

interface CustomerServiceInterface
{
    /**
     * Get a customer with its id.
     *
     * @param string $id
     */
    public function get($id);

    /**
     * Get list of customers
     *
     * @param integer $limit  The limit of the result.
     * @param integer $offset Starting from the offset.
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0);

    /**
     * Post Customer, creates a new Customer.
     *
     * @param array $parameters
     */
    public function post(array $parameters);
}