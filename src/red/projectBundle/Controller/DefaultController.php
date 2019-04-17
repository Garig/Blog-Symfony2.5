<?php

namespace red\projectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('redprojectBundle:Default:index.html.twig', array('name' => $name));
    }

}
