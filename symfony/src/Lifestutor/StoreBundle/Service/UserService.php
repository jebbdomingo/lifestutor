<?php

namespace Lifestutor\StoreBundle\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Lifestutor\StoreBundle\Form\UserType;
use Lifestutor\StoreBundle\Exception\InvalidFormException;

class UserService implements UserServiceInterface
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
     * Get specific user.
     *
     * @param string $username
     *
     * @return UserInterface
     */
    /*public function getUserByUsername($username)
    {
        //var_dump($this->security_context->getToken()->getUser()->getRoles());die;
        //var_dump($this->security_context->isGranted('ROLE_ADMIN'));die('hello');
        
        //if ($this->security_context->getToken()->isAuthenticated())

            return $this->repository->findOneBy(array('username' => $username));
        //else
        //    return new Response("Authentication Failed.", 403);
    }*/

    /**
     * Get specific user by id.
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
     * Get all users.
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
     * Create a new User.
     *
     * @param array $parameters
     *
     * @return UserInterface
     */
    public function post(array $parameters)
    {
        $user = $this->createUser();
        return $this->processForm($user, $parameters, 'POST');
    }

    /**
     * Processes the form.
     *
     * @param UserInterface $user
     * @param array         $parameters
     * @param String        $method
     *
     * @return UserInterface
     *
     * @throws Lifestutor\StoreBundle\Exception\InvalidFormException
     */
    private function processForm(UserInterface $user, array $parameters, $method = "PUT")
    {
        $form = $this->formFactory->create(new UserType(), $user, array('method' => $method));

        $encoded = $this->password_encoder->encodePassword($user, $parameters['password']);

        $parameters['password'] = $encoded;

        $form->submit($parameters, 'PATCH' !== $method);

        if ($form->isValid()) {
            $user = $form->getData();

            $this->dm->persist($user);
            $this->dm->flush($user);

            return $user;
        }

        error_log($form->getErrorsAsString(), 0, '/var/log/apache2/error.log');
        throw new InvalidFormException('Invalid submitted data', $form);
    }

    private function createUser()
    {
        return new $this->documentClass();
    }
}