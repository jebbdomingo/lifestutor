<?php

namespace Lifestutor\StoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @MongoDB\Document
 */
class Admin extends User
{
    /**
     * @MongoDB\String
     */
    protected $userType = 'Admin';
}
