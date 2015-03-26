<?php
namespace Lifestutor\StoreBundle\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

/**
 * API Key User Provider.
 * @implements UserProviderInterface
 */
class ApiKeyUserProvider implements UserProviderInterface
{
    /**
     * Document manager.
     */
    private $dm;

    public function __construct($doctrine_mongodb)
    {
        $this->dm = $doctrine_mongodb->getManager();
    }

    public function getUsernameForApiKey($apiKey)
    {
        // Look up the username based on the token in the database, via
        // an API call, or do something entirely different
        $accessToken = $this->dm->getRepository('LifestutorStoreBundle:AccessToken')->findOneBy(array('access_token' => $apiKey));
        return $accessToken->getUserId();
    }

    public function loadUserByUsername($username)
    {
        return $this->dm->getRepository('LifestutorStoreBundle:User')->findOneBy(array('username' => $username));
    }

    public function refreshUser(UserInterface $user)
    {
        // this is used for storing authentication in the session
        // but in this example, the token is sent in each request,
        // so authentication can be stateless. Throwing this exception
        // is proper to make things stateless
        throw new UnsupportedUserException();
    }

    public function supportsClass($class)
    {
        return 'Lifestutor\StoreBundle\Document\User' === $class;
    }
}