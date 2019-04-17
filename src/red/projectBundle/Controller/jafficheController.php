<?php

namespace red\projectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class jafficheController extends Controller
{
    public function indexAction()
    {
        return $this->render('redprojectBundle:jaffiche:index.html.twig');
    }

        public function poloAction()
    {
        $marque="dbzhb";
        $url=$this->generateUrl('vistaprint',array('marque'=>$marque));
        return $this->redirect($url);

    }

        public function tshirtAction()
    {
        $request=$this->getRequest();
        $request->query()->get("session");

        return $this->render('redprojectBundle:jaffiche:tshirt.html.twig');         
        
    }

        public function carteAction($marque)
    {

        return $this->render('redprojectBundle:jaffiche:carte.html.twig', array('marque' => $marque,'name'=>'Alex' ));
    }

        public function aspiAction()
    {
        return new Response ("salut ! C'est mmon aspi Red de marque Hoover");
    }
}