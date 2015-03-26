<?php

namespace Hydrators;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;
use Doctrine\ODM\MongoDB\Hydrator\HydratorInterface;
use Doctrine\ODM\MongoDB\UnitOfWork;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ODM. DO NOT EDIT THIS FILE.
 */
class LifestutorStoreBundleDocumentBillingAddressHydrator implements HydratorInterface
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
        if (isset($data['address1'])) {
            $value = $data['address1'];
            $return = (string) $value;
            $this->class->reflFields['address1']->setValue($document, $return);
            $hydratedData['address1'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['address2'])) {
            $value = $data['address2'];
            $return = (string) $value;
            $this->class->reflFields['address2']->setValue($document, $return);
            $hydratedData['address2'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['cityProvince'])) {
            $value = $data['cityProvince'];
            $return = (string) $value;
            $this->class->reflFields['cityProvince']->setValue($document, $return);
            $hydratedData['cityProvince'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['country'])) {
            $value = $data['country'];
            $return = (string) $value;
            $this->class->reflFields['country']->setValue($document, $return);
            $hydratedData['country'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['postal'])) {
            $value = $data['postal'];
            $return = (string) $value;
            $this->class->reflFields['postal']->setValue($document, $return);
            $hydratedData['postal'] = $return;
        }
        return $hydratedData;
    }
}