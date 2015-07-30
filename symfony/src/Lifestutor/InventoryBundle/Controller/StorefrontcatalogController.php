<?php

namespace Lifestutor\InventoryBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Lifestutor\InventoryBundle\Exception\InvalidFormException;

use Hateoas\Representation\PaginatedRepresentation;
use Hateoas\Representation\CollectionRepresentation;

use JMS\Serializer\SerializationContext;

class StorefrontcatalogController extends FOSRestController
{
    /**
     * Get single catalog.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a catalog for a given id",
     *   output = "Lifestutor\InventoryBundle\Document\Book",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the catalog is not found"
     *   }
     * )
     *
     * @param mixed  $id the catalog's id
     *
     * @return array
     *
     * @throws ResourceNotFoundException when book not exist
     */
    public function catalogAction($id)
    {
        $book = $this->getOr404($id);
        $view = $this->setInventorySerializationContext($this->view($book, Codes::HTTP_OK));

        return $this->handleView($view);
    }

    /**
     * Get all catalogs.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets all catalogs",
     *   output = "Lifestutor\InventoryBundle\Document\Book",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when no book is found"
     *   }
     * )
     *
     * @return array
     *
     * @throws ResourceNotFoundException when user not exist
     */
    public function allAction()
    {
        $catalogs = $this->get('lifestutor_inventory.catalog.service')->all(5, 0);

        $paginatedCollection = new PaginatedRepresentation(
            new CollectionRepresentation(
                $catalogs,
                'items', // embedded rel
                'items' // xml element name
            ),
            'lifestutor_inventory_book_all', // route
            array(), // route parameters
            1, // page
            5, // limit
            count($catalogs), // total pages
            'page',  // page route parameter name, optional, defaults to 'page'
            'limit', // limit route parameter name, optional, defaults to 'limit'
            false    // false = generate relative URIs
        );

        $view = $this->setInventorySerializationContext($this->view($paginatedCollection, Codes::HTTP_OK));

        return $this->handleView($view);
    }

    /**
     * Set serializtion context to Storefront group (for use with Storefront Web App)
     * 
     * @param FOS\RestBundle\View\View $view
     *
     * @return  FOS\RestBundle\View\View
     */
    private function setInventorySerializationContext($view)
    {
        $view->setSerializationContext(SerializationContext::create()->setGroups(array('Default', 'storefront')));

        return $view;
    }

    /**
     * Fetch the book or throw a 404 exception.
     *
     * @param mixed $id
     *
     * @return Lifestutor\InventoryBundle\Document\Book
     *
     * @throws ResourceNotFoundException
     */
    protected function getOr404($id)
    {
        $book = $this->get('lifestutor_inventory.catalog.service')->get($id);

        if (!$book) {
            throw new ResourceNotFoundException(sprintf('The resource \'%s\' was not found.', $id));
        }

        return $book;
    }

    /**
     * Options
     * 
     * @return Response
     */
    public function optionsAction()
    {
        $response = new Response();
        $response->headers->set('Allow', 'OPTIONS, GET, PATCH, POST, PUT');
        $response->headers->set('Access-Control-Allow-Headers', 'Authorization, X-Requested-With, Content-Type');
        $response->headers->set('Access-Control-Allow-Methods', 'OPTIONS, GET, PATCH, POST, PUT, DELETE');

        return $response;
    }
}