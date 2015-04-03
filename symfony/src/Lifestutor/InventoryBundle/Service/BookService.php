<?php

namespace Lifestutor\InventoryBundle\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormFactoryInterface;
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
     * Get specific customer by id.
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
     * Get all customers.
     *
     * @param integer $limit  The limit of the result.
     * @param integer $offset Starting from the offset.
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0)
    {
        return $this->repository->findAll();
    }

    /**
     * Create a new Customer.
     *
     * @param array $parameters
     *
     * @return UserInterface
     */
    public function post(array $parameters)
    {
        $book = $this->createBook();

        return $this->processForm($book, $parameters, 'POST');
    }

    /**
     * Processes the form.
     *
     * @param UserInterface $book
     * @param array         $parameters
     * @param String        $method
     *
     * @return UserInterface
     *
     * @throws Lifestutor\StoreBundle\Exception\InvalidFormException
     */
    private function processForm(UserInterface $book, array $parameters, $method = "PUT")
    {
        $form = $this->formFactory->create(new BookType(), $book, array('method' => $method));

        $form->submit($parameters, 'PATCH' !== $method);

        if ($form->isValid()) {
            $book = $form->getData();

            $this->dm->persist($book);
            $this->dm->flush($book);

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