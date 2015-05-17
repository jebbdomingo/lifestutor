<?php

namespace Lifestutor\InventoryBundle\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormFactoryInterface;
use Lifestutor\InventoryBundle\Document\Book;
use Lifestutor\InventoryBundle\Form\BookType;
use Lifestutor\InventoryBundle\Exception\InvalidFormException;

class BookService implements BookServiceInterface
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
     * Constructor
     * 
     * @param doctrine             $doctrine_mongodb
     * @param string               $documentClass
     * @param FormFactoryInterface $formFactory
     */
    public function __construct($doctrine_mongodb, $documentClass, FormFactoryInterface $formFactory)
    {
        $this->dm               = $doctrine_mongodb->getManager();
        $this->documentClass    = $documentClass;
        $this->repository       = $doctrine_mongodb->getRepository($documentClass);
        $this->formFactory      = $formFactory;
    }

    /**
     * Get specific book by id.
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
     * Get all books.
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
     * Create a new Book.
     *
     * @param array $parameters
     *
     * @return UserInterface
     */
    public function post(array $parameters)
    {
        $book = $this->createBook();
        $book->setDeleted(false);

        return $this->processForm($book, $parameters, 'POST');
    }

    /**
     * Update an existing Book.
     *
     * @param array $parameters
     *
     * @return UserInterface
     */
    public function put(array $parameters)
    {
        $book = $this->get($parameters['id']);

        return $this->processForm($book, $parameters, 'PUT');
    }

    /**
     * Delete a book by id.
     *
     * @param mixded $id
     *
     * @return UserInterface
     */
    public function delete($id)
    {
        $book = $this->get($id);
        $book->delete();

        $this->dm->persist($book);
        $this->dm->flush();

        return $book;
    }

    /**
     * Publish a book
     *
     * @param mixded $id
     *
     * @return UserInterface
     */
    public function publish($id)
    {
        $book = $this->get($id);

        $book->publish();

        $this->dm->persist($book);
        $this->dm->flush();

        return $book;
    }

    /**
     * Un-publish a book
     *
     * @param mixded $id
     *
     * @return UserInterface
     */
    public function unPublish($id)
    {
        $book = $this->get($id);

        $book->unPublish();

        $this->dm->persist($book);
        $this->dm->flush();

        return $book;
    }

    /**
     * Processes the form.
     *
     * @param Lifestutor\InventoryBundle\Document\Book  $book
     * @param array                                     $parameters
     * @param string                                    $method
     *
     * @return UserInterface
     *
     * @throws Lifestutor\StoreBundle\Exception\InvalidFormException
     */
    private function processForm(book $book, array $parameters, $method = "PUT")
    {
        $form = $this->formFactory->create(new BookType(), $book, array('method' => $method));

        $form->submit($parameters, 'PATCH' !== $method);

        if ($form->isValid()) {
            $book = $form->getData();

            $this->dm->persist($book);
            $this->dm->flush();

            return $book;
        }

        error_log($form->getErrorsAsString(), 0, '/var/log/apache2/error.log');
        throw new InvalidFormException('Invalid submitted data', $form);
    }

    /**
     * Create book entity
     * 
     * @return Lifestutor\StoreBundle\Document
     */
    private function createBook()
    {
        return new $this->documentClass();
    }
}