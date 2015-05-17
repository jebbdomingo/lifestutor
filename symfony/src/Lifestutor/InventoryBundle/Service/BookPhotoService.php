<?php

namespace Lifestutor\InventoryBundle\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormFactoryInterface;
use Lifestutor\InventoryBundle\Document\BookPhoto;
use Lifestutor\InventoryBundle\Form\BookPhotoType;
use Lifestutor\InventoryBundle\Exception\InvalidFormException;
use Symfony\Component\HttpFoundation\Request;

class BookPhotoService
{
    /**
     * Document manager.
     */
    private $dm;

    /**
     * Document repository.
     */
    private $repository;

    /**
     * Document class.
     */
    private $documentClass;

    /**
     * Form factory.
     */
    private $formFactory;

    /**
     * Book Service.
     */
    private $bookService;

    /**
     * Constructor
     * 
     * @param doctrine             $doctrine_mongodb
     * @param string               $documentClass
     * @param FormFactoryInterface $formFactory
     */
    public function __construct($doctrine_mongodb, $documentClass, FormFactoryInterface $formFactory, BookService $bookService)
    {
        $this->dm            = $doctrine_mongodb->getManager();
        $this->documentClass = $documentClass;
        $this->repository    = $doctrine_mongodb->getRepository($documentClass);
        $this->formFactory   = $formFactory;
        $this->bookService   = $bookService;
    }

    /**
     * Get specific photo by id.
     *
     * @param mixded $id
     *
     * @return UserInterface
     */
    public function get($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Get all photos.
     *
     * @param integer $limit  The limit of the result.
     * @param integer $offset Starting from the offset.
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0)
    {
        return $this->repository->findBy(
                array('deleted' => false)
            );
    }

    /**
     * Create a new Photo.
     *
     * @param Symfony\Component\HttpFoundation\Request $request
     *
     * @return UserInterface
     */
    public function post(Request $request)
    {
        $photo = $this->createPhoto();
        $photo->setDeleted(false);

        return $this->processForm($photo, $request, 'POST');
    }

    /**
     * Delete a photo by id.
     *
     * @param mixded $id
     *
     * @return UserInterface
     */
    public function delete($id)
    {
        $photo = $this->get($id);
        $photo->delete();

        $this->dm->persist($photo);
        $this->dm->flush();

        return $photo;
    }

    /**
     * Processes the form.
     *
     * @param Lifestutor\InventoryBundle\Document\BookPhoto $photo
     * @param array                                         $parameters
     * @param string                                        $method
     *
     * @return array
     *
     * @throws Lifestutor\StoreBundle\Exception\InvalidFormException
     */
    private function processForm(BookPhoto $photo, Request $request, $method = "PUT")
    {
        $bookId       = $request->request->get('book_id');
        $flowFilename = $request->request->get('flowFilename');

        $form = $this->formFactory->create(new BookPhotoType(), $photo, array('method' => $method));
        $form->submit($request->request->all(), 'PATCH' !== $method);

        $uploadedFile = $request->files->get('file');

        if ($form->isValid()) {
            $book      = $this->bookService->get($bookId);
            $photo     = $form->getData();
            $extension = $uploadedFile->guessExtension();

            if (!$extension) {
                // extension cannot be guessed
                $extension = 'bin';
            }

            $photo->setFilename($flowFilename, $extension);
            $book->addPhoto($photo);

            $uploadedFile->move($photo->getUploadRootDir(), $photo->getFilename());

            $this->dm->persist($photo);
            $this->dm->flush();

            return $photo;

            //error_log(print_r($photo, true), 0, '/var/log/apache2/error.log');
        } else {
            error_log($form->getErrorsAsString(), 0, '/var/log/apache2/error.log');
            throw new InvalidFormException('Invalid submitted data', $form);
        }
    }

    /**
     * Create photo entity
     * 
     * @return Lifestutor\StoreBundle\Document
     */
    private function createPhoto()
    {
        return new $this->documentClass();
    }
}