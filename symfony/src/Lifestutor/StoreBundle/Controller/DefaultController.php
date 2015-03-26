<?php

namespace Lifestutor\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Lifestutor\StoreBundle\Document\Status,
    Lifestutor\StoreBundle\Document\Shop,
    Lifestutor\StoreBundle\Document\Item,
    Lifestutor\StoreBundle\Document\User;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        //return $this->render('::base.html.twig');

        $dm = $this->get('doctrine_mongodb')->getManager();


        $user = new User();
        $user->setUsername('testuser');
        $user->setPassword('$2y$14$f3qml4G2hG6sxM26VMq.geDYbsS089IBtVJ7DlD05BoViS9PFykE2');
        $user->setSalt('123');
        $user->setRoles(array('ROLE_USER', 'ROLE_ADMIN'));
        $user->setFirstName('Juan');
        $user->setLastName('Dela Cruz');
        $dm->persist($user);

        $shop = new Shop();
        $shop->setName("Yantinvea Car Accessories");
        $shop->setUser($user);
        $dm->persist($shop);

        $item1 = new Item();
        $item1->setName('Item 2')
                 ->setPrice('1300.00')
                 ->setShop($shop);
        $dm->persist($item1);

        $item2 = new Item();
        $item2->setName('Item 1')
                 ->setPrice('2899.00')
                 ->setShop($shop);
        $dm->persist($item2);

        $dm->flush();
        
        return $this->render('LifestutorStoreBundle:Default:index.html.twig', array('name' => $name));
    }
}
