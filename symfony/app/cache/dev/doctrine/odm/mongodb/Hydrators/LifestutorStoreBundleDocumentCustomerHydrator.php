<?php

namespace Hydrators;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;
use Doctrine\ODM\MongoDB\Hydrator\HydratorInterface;
use Doctrine\ODM\MongoDB\UnitOfWork;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ODM. DO NOT EDIT THIS FILE.
 */
class LifestutorStoreBundleDocumentCustomerHydrator implements HydratorInterface
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

        /** @Field(type="id") */
        if (isset($data['_id'])) {
            $value = $data['_id'];
            $return = $value instanceof \MongoId ? (string) $value : $value;
            $this->class->reflFields['id']->setValue($document, $return);
            $hydratedData['id'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['userType'])) {
            $value = $data['userType'];
            $return = (string) $value;
            $this->class->reflFields['userType']->setValue($document, $return);
            $hydratedData['userType'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['username'])) {
            $value = $data['username'];
            $return = (string) $value;
            $this->class->reflFields['username']->setValue($document, $return);
            $hydratedData['username'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['password'])) {
            $value = $data['password'];
            $return = (string) $value;
            $this->class->reflFields['password']->setValue($document, $return);
            $hydratedData['password'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['salt'])) {
            $value = $data['salt'];
            $return = (string) $value;
            $this->class->reflFields['salt']->setValue($document, $return);
            $hydratedData['salt'] = $return;
        }

        /** @Field(type="collection") */
        if (isset($data['roles'])) {
            $value = $data['roles'];
            $return = $value;
            $this->class->reflFields['roles']->setValue($document, $return);
            $hydratedData['roles'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['firstname'])) {
            $value = $data['firstname'];
            $return = (string) $value;
            $this->class->reflFields['firstname']->setValue($document, $return);
            $hydratedData['firstname'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['lastname'])) {
            $value = $data['lastname'];
            $return = (string) $value;
            $this->class->reflFields['lastname']->setValue($document, $return);
            $hydratedData['lastname'] = $return;
        }

        /** @EmbedOne */
        if (isset($data['billingAddress'])) {
            $embeddedDocument = $data['billingAddress'];
            $className = $this->unitOfWork->getClassNameForAssociation($this->class->fieldMappings['billingAddress'], $embeddedDocument);
            $embeddedMetadata = $this->dm->getClassMetadata($className);
            $return = $embeddedMetadata->newInstance();

            $embeddedData = $this->dm->getHydratorFactory()->hydrate($return, $embeddedDocument, $hints);
            $embeddedId = $embeddedMetadata->identifier && isset($embeddedData[$embeddedMetadata->identifier]) ? $embeddedData[$embeddedMetadata->identifier] : null;

            $this->unitOfWork->registerManaged($return, $embeddedId, $embeddedData);
            $this->unitOfWork->setParentAssociation($return, $this->class->fieldMappings['billingAddress'], $document, 'billingAddress');

            $this->class->reflFields['billingAddress']->setValue($document, $return);
            $hydratedData['billingAddress'] = $return;
        }

        /** @EmbedOne */
        if (isset($data['shippingAddress'])) {
            $embeddedDocument = $data['shippingAddress'];
            $className = $this->unitOfWork->getClassNameForAssociation($this->class->fieldMappings['shippingAddress'], $embeddedDocument);
            $embeddedMetadata = $this->dm->getClassMetadata($className);
            $return = $embeddedMetadata->newInstance();

            $embeddedData = $this->dm->getHydratorFactory()->hydrate($return, $embeddedDocument, $hints);
            $embeddedId = $embeddedMetadata->identifier && isset($embeddedData[$embeddedMetadata->identifier]) ? $embeddedData[$embeddedMetadata->identifier] : null;

            $this->unitOfWork->registerManaged($return, $embeddedId, $embeddedData);
            $this->unitOfWork->setParentAssociation($return, $this->class->fieldMappings['shippingAddress'], $document, 'shippingAddress');

            $this->class->reflFields['shippingAddress']->setValue($document, $return);
            $hydratedData['shippingAddress'] = $return;
        }

        /** @EmbedOne */
        if (isset($data['cart'])) {
            $embeddedDocument = $data['cart'];
            $className = $this->unitOfWork->getClassNameForAssociation($this->class->fieldMappings['cart'], $embeddedDocument);
            $embeddedMetadata = $this->dm->getClassMetadata($className);
            $return = $embeddedMetadata->newInstance();

            $embeddedData = $this->dm->getHydratorFactory()->hydrate($return, $embeddedDocument, $hints);
            $embeddedId = $embeddedMetadata->identifier && isset($embeddedData[$embeddedMetadata->identifier]) ? $embeddedData[$embeddedMetadata->identifier] : null;

            $this->unitOfWork->registerManaged($return, $embeddedId, $embeddedData);
            $this->unitOfWork->setParentAssociation($return, $this->class->fieldMappings['cart'], $document, 'cart');

            $this->class->reflFields['cart']->setValue($document, $return);
            $hydratedData['cart'] = $return;
        }
        return $hydratedData;
    }
}