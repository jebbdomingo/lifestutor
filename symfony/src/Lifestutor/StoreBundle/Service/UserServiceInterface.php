<?php

namespace Lifestutor\StoreBundle\Service;

use Symfony\Component\Security\Core\User\UserInterface;

interface UserServiceInterface
{
    /**
     * Get a user with its id.
     *
     * @param string $id
     *
     * @return UserInterface
     */
    public function get($id);

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
     * @return UserInterface
     */
    public function post(array $parameters);
}