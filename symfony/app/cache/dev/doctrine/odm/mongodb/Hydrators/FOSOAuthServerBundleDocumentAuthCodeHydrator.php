<?php

namespace Hydrators;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;
use Doctrine\ODM\MongoDB\Hydrator\HydratorInterface;
use Doctrine\ODM\MongoDB\UnitOfWork;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ODM. DO NOT EDIT THIS FILE.
 */
class FOSOAuthServerBundleDocumentAuthCodeHydrator implements HydratorInterface
{
    private $dm;
    private $unitOfWork;
    private $class;

    public function __construct(DocumentManager $dm, UnitOfWork $uow, ClassMetadata $class)
    {
        $this->dm = $dm;
        $this->unitOfWork = $uow;
        $this->class = $class;
    }

    public function hydrate($document, $data, array $hints = array())
    {
        $hydratedData = array();

        /** @Field(type="string") */
        if (isset($data['token'])) {
            $value = $data['token'];
            $return = (string) $value;
            $this->class->reflFields['token']->setValue($document, $return);
            $hydratedData['token'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['redirectUri'])) {
            $value = $data['redirectUri'];
            $return = (string) $value;
            $this->class->reflFields['redirectUri']->setValue($document, $return);
            $hydratedData['redirectUri'] = $return;
        }

        /** @Field(type="int") */
        if (isset($data['expiresAt'])) {
            $value = $data['expiresAt'];
            $return = (int) $value;
            $this->class->reflFields['expiresAt']->setValue($document, $return);
            $hydratedData['expiresAt'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['scope'])) {
            $value = $data['scope'];
            $return = (string) $value;
            $this->class->reflFields['scope']->setValue($document, $return);
            $hydratedData['scope'] = $return;
        }
        return $hydratedData;
    }
}