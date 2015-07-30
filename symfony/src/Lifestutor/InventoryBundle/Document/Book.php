<?php

namespace Lifestutor\InventoryBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;

/**
 * @MongoDB\Document
 * @Serializer\XmlRoot("book")
 * @Hateoas\Relation("self", href = "expr('/api/v1/books/' ~ object.getId())")
 */
class Book extends Item
{
    /**
     * @MongoDB\ReferenceMany(targetDocument="BookPhoto", mappedBy="book")
     * @Expose
     * @Groups({"inventory", "storefront"})
     */
    private $bookPhotos = array();

    /**
     * @MongoDB\String
     */
    protected $itemType = 'Book';

    /**
     * Delete use case
     * 
     * @return self
     */
    public function delete()
    {
        $this->deleted = true;

        return $this;
    }

    /**
     * Get photos
     * 
     * @return array
     */
    public function initializePhotos()
    {
        // Removed photos marked as deleted.
        foreach ($this->bookPhotos as $id => $photo) {
            //error_log(print_r($id, true), 0, '/var/log/apache2/error.log');
            if (!$photo->isDeleted()) {
                $this->bookPhotos[$id] = $photo;
            } else {
                unset($this->bookPhotos[$id]);
            }
        }
    }

    /**
     * Get photos
     * 
     * @return array
     */
    public function getPhotos()
    {
        $this->initializePhotos();

        return $this->bookPhotos;
    }

    /**
     * Add a photo
     * 
     * @param BookPhoto $photo [description]
     *
     * @return self
     */
    public function addPhoto(BookPhoto $photo)
    {
        $photo->setBook($this);

        return $this;
    }
}