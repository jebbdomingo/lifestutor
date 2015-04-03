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

use Lifestutor\StoreBundle\Document\User;

class UserController extends FOSRestController
{
    /*public function createUserAction()
    {
        //return $this->render('::base.html.twig');

        $dm = $this->get('doctrine_mongodb')->getManager();

        $user = new User();
        $user->setUsername('user@domain.com');
        $user->setPassword('$2a$12$zEl9Pl5fJjimtkjGxOhOhONUUzDJvJiucYbaTat2LbP4/W2a90XIi');
        $user->setSalt('123');
        $user->setRoles(array('ROLE_USER', 'ROLE_ADMIN'));
        $user->setFirstName('Juan');
        $user->setLastName('Dela Cruz');
        $dm->persist($user);

        $shop = new Shop();
        $shop->setName("Yantinvea Car Accessories");
        $user->addShop($shop);
        $dm->persist($shop);

        $item = new ShopItem();
        $item->setName('Shop Item 1')
             ->setPrice('1300.00');
        $shop->addItem($item);
        $dm->persist($item);

        $item = new ShopItem();
        $item->setName('Shop Item 2')
             ->setPrice('2899.00');
        $shop->addItem($item);
        $dm->persist($item);

        $item = new UserItem();
        $item->setName('User Item 1')
             ->setPrice('1500.00');
        $user->addItem($item);
        $dm->persist($item);

        $item = new UserItem();
        $item->setName('User Item 2')
             ->setPrice('1800.00');
        $user->addItem($item);
        $dm->persist($item);

        $dm->flush();
        
        $view = $this->view($user, Codes::HTTP_CREATED);
        $view->setFormat('json');

        return $this->handleView($view);
    }*/

    /**
     * Get single user.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a User for a given username",
     *   output = "Lifestutor\StoreBundle\Document\User",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the user is not found"
     *   }
     * )
     *
     * @param mixed  $id the user's id
     *
     * @return array
     *
     * @throws ResourceNotFoundException when user not exist
     */
    public function getUserAction($id)
    {
        $user = $this->getOr404($id);

        $view = $this->view($user, Codes::HTTP_OK);
        //$view->setFormat('json');

        return $this->handleView($view);
    }

    public function getLoggedinuserAction()
    {
        //$this->generateFixtures();

        //error_log(print_r($this->get('security.context')->getToken(), true));die;
        $id   = $this->get('security.context')->getToken()->getUser()->getId();
        $user = array('user' => $this->getOr404($id));
        $view = $this->view($user, Codes::HTTP_OK);

        return $this->handleView($view);
    }

    private function generateFixtures()
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
    }

    public function optionsLoggedinuserAction()
    {
        $response = new Response();
        $response->headers->set('Allow', 'OPTIONS, GET, PATCH, POST');
        $response->headers->set('Access-Control-Allow-Headers', 'Authorization, X-Requested-With, Content-Type');
        
        return $response;
    }

    /**
     * Fetch the User or throw a 404 exception.
     *
     * @param mixed $id
     *
     * @return UserInterface
     *
     * @throws ResourceNotFoundException
     */
    protected function getOr404($id)
    {
        $user = $this->get('lifestutor_store.user.service')->get($id);
        //error_log(print_r(get_class($user), true));

        if (!$user) {
            throw new ResourceNotFoundException(sprintf('The resource \'%s\' was not found.', $id));
        }

        return $user;
    }

    /**
     * Create a User from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new user from the submitted data.",
     *   input = "Lifestutor\StoreBundle\Form\UserType",
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
    /*public function postUserAction(Request $request)
    {
        try {
            $user = $this->container->get('lifestutor_store.user.service')->post($request->request->all());

            $view = $this->view($user, Codes::HTTP_CREATED);
            $view->setFormat('json');

            return $this->handleView($view);
        } catch (InvalidFormException $exception) {
            $view = $this->view($exception->getForm(), Codes::HTTP_BAD_REQUEST);
            $view->setFormat('json');
            return $this->handleView($view);
        }
    }

    public function optionsUsersAction()
    {
        $response = new Response();
        $response->headers->set('Allow', 'OPTIONS, GET, PATCH, POST');
        $response->headers->set('Access-Control-Allow-Headers', 'Authorization, X-Requested-With, Content-Type');
        
        return $response;
    }*/

    /**
     * Get user items.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets item of a user for a given user id",
     *   output = "Lifestutor\StoreBundle\Document\Item",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when no item is found"
     *   }
     * )
     *
     * @param mixed  $id the user's id
     *
     * @return array
     *
     * @throws ResourceNotFoundException when user not exist
     */
    /*public function itemsAction($id)
    {
        $user  = $this->getOr404($id);
        $items = $user->getItems();

        $paginatedCollection = new PaginatedRepresentation(
            new CollectionRepresentation(
                $items,
                'items', // embedded rel
                'items' // xml element name
            ),
            'lifestutor_store_item_all', // route
            array(), // route parameters
            1, // page
            5, // limit
            count($items), // total pages
            'page',  // page route parameter name, optional, defaults to 'page'
            'limit', // limit route parameter name, optional, defaults to 'limit'
            false    // generate relative URIs
        );

        $view  = $this->view($paginatedCollection, Codes::HTTP_OK);

        return $this->handleView($view);
    }*/
}