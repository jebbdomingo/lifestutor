<?php

namespace Hydrators;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;
use Doctrine\ODM\MongoDB\Hydrator\HydratorInterface;
use Doctrine\ODM\MongoDB\UnitOfWork;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ODM. DO NOT EDIT THIS FILE.
 */
class LifestutorOAuthServerBundleDocumentRefreshTokenHydrator implements HydratorInterface
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

        /** @Field(type="id") */
        if (isset($data['_id'])) {
            $value = $data['_id'];
            $return = $value instanceof \MongoId ? (string) $value : $value;
            $this->class->reflFields['id']->setValue($document, $return);
            $hydratedData['id'] = $return;
        }

        /** @ReferenceOne */
        if (isset($data['client'])) {
            $reference = $data['client'];
            if (isset($this->class->fieldMappings['client']['simple']) && $this->class->fieldMappings['client']['simple']) {
                $className = $this->class->fieldMappings['client']['targetDocument'];
                $mongoId = $reference;
            } else {
                $className = $this->unitOfWork->getClassNameForAssociation($this->class->fieldMappings['client'], $reference);
                $mongoId = $reference['$id'];
            }
            $targetMetadata = $this->dm->getClassMetadata($className);
            $id = $targetMetadata->getPHPIdentifierValue($mongoId);
            $return = $this->dm->getReference($className, $id);
            $this->class->reflFields['client']->setValue($document, $return);
            $hydratedData['client'] = $return;
        }
        return $hydratedData;
    }
}