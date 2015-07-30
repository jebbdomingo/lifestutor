<?php

namespace Lifestutor\PhotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('LifestutorPhotoBundle:Default:index.html.twig', array('name' => $name));
    }
}
