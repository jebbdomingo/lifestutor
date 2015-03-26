<?php

namespace Lifestutor\StoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Lifestutor\StoreBundle\Exception\InvalidFormException;

use Hateoas\Representation\PaginatedRepresentation;
use Hateoas\Representation\CollectionRepresentation;

class ShopController extends FOSRestController
{
    public function allAction()
    {
        $shops = $this->get('lifestutor_store.shop.service')->all(5, 0);

        $paginatedCollection = new PaginatedRepresentation(
            new CollectionRepresentation(
                $shops,
                'shops', // embedded rel
                'shops' // xml element name
            ),
            'lifestutor_store_shop_all', // route
            array(), // route parameters
            1, // page
            5, // limit
            count($shops), // total pages
            'page',  // page route parameter name, optional, defaults to 'page'
            'limit', // limit route parameter name, optional, defaults to 'limit'
            false    // generate relative URIs
        );

        $view  = $this->view($paginatedCollection, Codes::HTTP_OK);

        return $this->handleView($view);
    }

    public function optionsAction()
    {
        $response = new Response();
        $response->headers->set('Allow', 'OPTIONS, GET, PATCH, POST');
        $response->headers->set('Access-Control-Allow-Headers', 'Authorization, X-Requested-With, Content-Type');
        
        return $response;
    }
}