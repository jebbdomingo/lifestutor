<?php

namespace Lifestutor\OAuthServerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('LifestutorApiBundle:Default:index.html.twig', array('name' => $name));
    }
}
