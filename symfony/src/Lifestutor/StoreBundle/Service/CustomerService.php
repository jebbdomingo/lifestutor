<?php

namespace Lifestutor\StoreBundle\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Lifestutor\StoreBundle\Form\CustomerType;
use Lifestutor\StoreBundle\Exception\InvalidFormException;

class CustomerService implements CustomerServiceInterface
{
    /**
     * Security context
     */
    private $security_context;

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
     * Password encoder.
     */
    private $password_encoder;

    /**
     * Constructor
     *
     * @param $security_context
     * @param @doctrine_mongodb
     */
    public function __construct($security_context, $doctrine_mongodb, $documentClass, FormFactoryInterface $formFactory, $password_encoder)
    {
        $this->security_context = $security_context;
        $this->dm               = $doctrine_mongodb->getManager();
        $this->documentClass    = $documentClass;
        $this->repository       = $doctrine_mongodb->getRepository($documentClass);
        $this->formFactory      = $formFactory;
        $this->password_encoder = $password_encoder;
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
        $customer = $this->createCustomer();

        return $this->processForm($customer, $parameters, 'POST');
    }

    /**
     * Processes the form.
     *
     * @param UserInterface $customer
     * @param array         $parameters
     * @param String        $method
     *
     * @return UserInterface
     *
     * @throws Lifestutor\StoreBundle\Exception\InvalidFormException
     */
    private function processForm(UserInterface $customer, array $parameters, $method = "PUT")
    {
        $form = $this->formFactory->create(new CustomerType(), $customer, array('method' => $method));

        $encoded = $this->password_encoder->encodePassword($customer, $parameters['password']);

        $parameters['password'] = $encoded;

        $form->submit($parameters, 'PATCH' !== $method);

        if ($form->isValid()) {
            $customer = $form->getData();

            $this->dm->persist($customer);
            $this->dm->flush($customer);

            return $customer;
        }

        error_log($form->getErrorsAsString(), 0, '/var/log/apache2/error.log');
        throw new InvalidFormException('Invalid submitted data', $form);
    }

    /**
     * Create customer entity
     * 
     * @return Lifestutor\StoreBundle\Document
     */
    private function createCustomer()
    {
        return new $this->documentClass();
    }
}