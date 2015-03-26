<?php

namespace Lifestutor\OAuthServerBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use FOS\OAuthServerBundle\Document\AccessToken as BaseAccessToken;
use FOS\OAuthServerBundle\Model\ClientInterface;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @MongoDB\Document
 */
class AccessToken extends BaseAccessToken 
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Client", inversedBy="accessTokens")
     */
    protected $client;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Lifestutor\StoreBundle\Document\User")
     */
    protected $user;

    public function getClient()
    {
        return $this->client;
    }

    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function setUser(UserInterface $user)
    {
        $this->user = $user;
    }

}