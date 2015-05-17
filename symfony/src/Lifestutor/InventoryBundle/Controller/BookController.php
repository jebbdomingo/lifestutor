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

class BookController extends FOSRestController
{
    /**
     * Get single book.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a book for a given id",
     *   output = "Lifestutor\InventoryBundle\Document\Book",
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
    public function bookAction($id)
    {
        $book = $this->getOr404($id);
        $view = $this->setInventorySerializationContext($this->view($book, Codes::HTTP_OK));

        return $this->handleView($view);
    }

    /**
     * Get all books.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets all books",
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
        $books = $this->get('lifestutor_store.book.service')->all(5, 0);

        $paginatedCollection = new PaginatedRepresentation(
            new CollectionRepresentation(
                $books,
                'items', // embedded rel
                'items' // xml element name
            ),
            'lifestutor_inventory_book_all', // route
            array(), // route parameters
            1, // page
            5, // limit
            count($books), // total pages
            'page',  // page route parameter name, optional, defaults to 'page'
            'limit', // limit route parameter name, optional, defaults to 'limit'
            false    // false = generate relative URIs
        );

        $view = $this->setInventorySerializationContext($this->view($paginatedCollection, Codes::HTTP_OK));

        return $this->handleView($view);
    }

    /**
     * Create a Book from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new book from the submitted data.",
     *   input = "Lifestutor\InventoryBundle\Form\BookType",
     *   statusCodes = {
     *     201 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postAction(Request $request)
    {
        try {
            $book = $this->container->get('lifestutor_store.book.service')->post($request->request->all());
            $view = $this->view($book, Codes::HTTP_CREATED);
        } catch (InvalidFormException $exception) {
            $view = $this->view($exception->getForm(), Codes::HTTP_BAD_REQUEST);
        }

        //$view->setFormat('json');

        return $this->handleView($view);
    }

    /**
     * Update a Book from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Updates a book woth the submitted data.",
     *   input = "Lifestutor\InventoryBundle\Form\BookType",
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
    public function updateAction(Request $request)
    {
        try {
            $book = $this->container->get('lifestutor_store.book.service')->put($request->request->all());
            $view = $this->view($book, Codes::HTTP_OK);
        } catch (InvalidFormException $exception) {
            $view = $this->view($exception->getForm(), Codes::HTTP_BAD_REQUEST);
        }

        //$view->setFormat('json');
        
        return $this->handleView($view);
    }

    /**
     * Delete a book.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Deletes a book with a given id",
     *   input = "Lifestutor\InventoryBundle\Document\Book",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the book is not found"
     *   }
     * )
     *
     * @param mixed  $id the book's id
     *
     * @return FormTypeInterface|View
     *
     * @throws ResourceNotFoundException when book not exist
     */
    public function deleteAction($id)
    {
        $book = $this->container->get('lifestutor_store.book.service')->delete($id);
        $view = $this->setInventorySerializationContext($this->view($book, Codes::HTTP_OK));

        return $this->handleView($view);
    }

    /**
     * Patch a book.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Deletes a book with a given id",
     *   input = "Lifestutor\InventoryBundle\Document\Book",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the book is not found"
     *   }
     * )
     *
     * @param mixed  $id the book's id
     *
     * @return FormTypeInterface|View
     *
     * @throws ResourceNotFoundException when book not exist
     */
    public function patchAction($id, Request $request)
    {
        $patchInstruction = $request->request->all();

        foreach ($patchInstruction as $instruction) {
            switch ($instruction['operation']) {
                case 'publish':
                    $book = $this->container->get('lifestutor_store.book.service')->publish($id);
                    break;

                case 'unpublish':
                    $book = $this->container->get('lifestutor_store.book.service')->unPublish($id);
                    break;
            }
        }

        $view = $this->setInventorySerializationContext($this->view($book, Codes::HTTP_OK));

        return $this->handleView($view);
    }

    /**
     * Upload action
     * 
     * @param  Request $request
     * 
     * @return FormTypeInterface|View
     */
    public function uploadAction(Request $request)
    {
        try {
            $books = $this->container->get('lifestutor_store.book_photo.service')->post($request);
            $view = $this->view($books, Codes::HTTP_CREATED);
        } catch (InvalidFormException $exception) {
            $view = $this->view($exception->getForm(), Codes::HTTP_BAD_REQUEST);
        }

        return $this->handleView($view);
    }

    /*private function generateFixtures()
    {
        $dm = $this->get('doctrine_mongodb')->getManager();

        // Generate Catalogs.
        $aCatalogs = array(
            'Health and Home',
            'Food Supplements',
            'Family'
        );

        foreach ($aCatalogs as $aCatalog) {
            $catalog2 = new \Lifestutor\InventoryBundle\Document\Catalog($aCatalog);
            $catalog2->publish();
            $dm->persist($catalog2);
            //$catalog = $catalog2;
        }

        $dm->flush();

        $randCatalogs = array();

        // Get catalog.
        $catalogs = $dm->getRepository('\Lifestutor\InventoryBundle\Document\Catalog')->findAll();

        foreach ($catalogs as $catalog) {
            $randCatalogs[] = $catalog;
        }

        // Generate Books.
        $aBooks = array(
            array(
                'name' => "Sample Book 1",
                'cost' => 10.00,
                'sellingPrice' => 25.00,
                'quantity' => 15,
                'rewardPoint' => .5,
                'publish' => true
            ),
            array(
                'name' => "Sample Book 2",
                'cost' => 12.00,
                'sellingPrice' => 30.00,
                'quantity' => 10,
                'rewardPoint' => .5,
                'publish' => true
            ),
            array(
                'name' => "Sample Book 3",
                'cost' => 35.00,
                'sellingPrice' => 150.00,
                'quantity' => 8,
                'rewardPoint' => 2,
                'publish' => true
            )
        );

        foreach ($aBooks as $key => $sampleBook) {
            $book = new \Lifestutor\InventoryBundle\Document\Book($sampleBook['name']);
            $book->setCost($sampleBook['cost']);
            $book->setSellingPrice($sampleBook['sellingPrice']);
            $book->setQuantity($sampleBook['quantity']);
            $book->setRewardPoint($sampleBook['rewardPoint']);
            $book->publish(true);
            $book->addCatalog($randCatalogs[$key]);

            $dm->persist($book);
        }

        $dm->flush();
    }*/

    /**
     * Set serializtion context to Inventory group (for use with Inventory Web App)
     * 
     * @param FOS\RestBundle\View\View $view
     *
     * @return  FOS\RestBundle\View\View
     */
    private function setInventorySerializationContext($view)
    {
        $view->setSerializationContext(SerializationContext::create()->setGroups(array('Default', 'inventory')));

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
        $book = $this->get('lifestutor_store.book.service')->get($id);
        //error_log(print_r(get_class($book), true));

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