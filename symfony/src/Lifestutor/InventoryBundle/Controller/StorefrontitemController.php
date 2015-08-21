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

class StorefrontItemController extends FOSRestController
{
    /**
     * Get all items.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets all books",
     *   output = "Lifestutor\InventoryBundle\Document\Item",
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
        $items = $this->get('lifestutor_inventory.item.service')->all(5, 0);

        $paginatedCollection = new PaginatedRepresentation(
            new CollectionRepresentation(
                $items,
                'items', // embedded rel
                'items' // xml element name
            ),
            'lifestutor_inventory_storefront_items_all', // route
            array(), // route parameters
            1, // page
            5, // limit
            count($items), // total pages
            'page',  // page route parameter name, optional, defaults to 'page'
            'limit', // limit route parameter name, optional, defaults to 'limit'
            false    // false = generate relative URIs
        );

        $view = $this->setInventorySerializationContext($this->view($paginatedCollection, Codes::HTTP_OK));

        return $this->handleView($view);
    }

    /**
     * Get single item.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a book for a given id",
     *   output = "Lifestutor\InventoryBundle\Document\Item",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the book is not found"
     *   }
     * )
     *
     * @param mixed  $id the book's id
     *
     * @return array
     *
     * @throws ResourceNotFoundException when book not exist
     */
    public function itemAction($id)
    {
        $item = $this->getOr404($id);
        $view = $this->setInventorySerializationContext($this->view($item, Codes::HTTP_OK));

        return $this->handleView($view);
    }

    /**
     * Get selected catalog items.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets selected catalog items",
     *   output = "Lifestutor\InventoryBundle\Document\Item",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when no item is found"
     *   }
     * )
     *
     * @return array
     *
     * @throws ResourceNotFoundException when user not exist
     */
    public function catalog_itemsAction($catalog_id)
    {
        $items = $this->get('lifestutor_inventory.item.service')->getItemsByCatalog($catalog_id, 5, 0);

        $paginatedCollection = new PaginatedRepresentation(
            new CollectionRepresentation(
                $items,
                'items', // embedded rel
                'items' // xml element name
            ),
            'lifestutor_inventory_storefront_catalog_items', // route
            array('catalog_id' => $catalog_id), // route parameters
            1, // page
            5, // limit
            count($items), // total pages
            'page',  // page route parameter name, optional, defaults to 'page'
            'limit', // limit route parameter name, optional, defaults to 'limit'
            false    // false = generate relative URIs
        );

        $view = $this->setInventorySerializationContext($this->view($paginatedCollection, Codes::HTTP_OK));

        return $this->handleView($view);
    }

    /**
     * Set serializtion context to Inventory group (for use with Inventory Web App)
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
     * Fetch the item or throw a 404 exception.
     *
     * @param mixed $id
     *
     * @return Lifestutor\InventoryBundle\Document\Book
     *
     * @throws ResourceNotFoundException
     */
    protected function getOr404($id)
    {
        $item = $this->get('lifestutor_inventory.item.service')->get($id);

        if (!$item) {
            throw new ResourceNotFoundException(sprintf('The resource \'%s\' was not found.', $id));
        }

        return $item;
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