<?php
namespace Lifestutor\StoreBundle\DataFixtures\MongoDB;

use Lifestutor\StoreBundle\Document\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData implements FixtureInterface
{
    static public $users = array();

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('testuser@domain.com');
        $manager->persist($user);
        $manager->flush();
        self::$users[] = $user;
    }
}