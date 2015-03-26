<?php

namespace Lifestutor\OAuthServerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Lifestutor\StoreBundle\Exception\InvalidFormException;

class SignupController extends FOSRestController
{
    /**
     * Create a Customer from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new customer from the submitted data.",
     *   input = "Lifestutor\StoreBundle\Form\CustomerType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postSignupAction(Request $request)
    {
        error_log(print_r($request->request->all(), true));
        try {
            $customer = $this->container->get('lifestutor_store.customer.service')->post($request->request->all());

            $view = $this->view($customer, Codes::HTTP_CREATED);
            $view->setFormat('json');

            return $this->handleView($view);
        } catch (InvalidFormException $exception) {
            $view = $this->view($exception->getForm(), Codes::HTTP_BAD_REQUEST);
            $view->setFormat('json');
            return $this->handleView($view);
        }
    }

    /**
     * [optionsSignupsAction description]
     * @return Response
     */
    public function optionsSignupsAction()
    {
        $response = new Response();
        $response->headers->set('Allow', 'OPTIONS, GET, PATCH, POST');

        // @todo Authorization will not work in succeeding signup without refreshing the page
        $response->headers->set('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Authorization');
        
        return $response;
    }
}