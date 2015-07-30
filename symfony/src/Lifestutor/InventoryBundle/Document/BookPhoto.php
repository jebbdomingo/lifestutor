<?php

namespace Lifestutor\InventoryBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;

/**
 * @MongoDB\Document
 * @MongoDB\Index(unique=true, order="asc")
 * @ExclusionPolicy("all")
 */
class BookPhoto
{
    /**
     * @MongoDB\Id
     * @Expose
     */
    protected $id;

    /**
     * @MongoDB\String
     * @Expose
     * @Groups({"inventory", "storefront"})
     */
    protected $name;

    /**
     * @MongoDB\String
     * @Expose
     * @Groups({"inventory", "storefront"})
     */
    protected $filename;

    /**
     * @MongoDB\Boolean
     * @Expose
     * @Groups({"inventory"})
     */
    protected $deleted;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Book", inversedBy="bookPhotos")
     */
    private $book;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->deleted = false;
    }

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get id
     *
     * @return id $id
     */
    public function setId($id)
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set filename
     *
     * @param  mixed  $filename  Filename of the photo
     * @param  string $extension File extension of the photo
     * 
     * @return self
     */
    public function setFilename($filename, $extension)
    {
        $this->filename = $this->generateRandomFilename($filename, $extension);
        return $this;
    }

    /**
     * Get filename
     *
     * @return string $name
     */
    public function getFilename()
    {
        return $this->filename;
    }

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
     * Set deleted
     *
     * @param boolean $bool
     * @return self
     */
    public function setDeleted($bool)
    {
        $this->deleted = $bool;
        return $this;
    }

    /**
     * Is deleted
     *
     * @return boolean $deleted
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Get upload root directory
     * 
     * @return string
     */
    public function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    /**
     * Get upload relative directory
     * 
     * @return string
     */
     public function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/book_photos';
    }

    /**
     * Generate a random file name for the book photo.
     * 
     * @param  mixed  $filename  Filename of the photo
     * @param  string $extension File extension of the photo
     * 
     * @return string
     */
    protected function generateRandomFilename($filename, $extension)
    {
        return "{$filename}-" . sha1(uniqid(mt_rand(), true)) . ".{$extension}";
    }

    public function setBook(Book $book)
    {
        $this->book = $book;
    }
}