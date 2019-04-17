<?php

namespace Ecommerce\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($nom, $prenom)
    {
        $tonton='Jacky';
        $tontons=array('tonton1','tonton2','tonton3');
        return $this->render('EcommerceBundle:Default:index.html.twig', array('nom' => $nom,
        																	  'prenom'=>$prenom,
        																	  'tonton'=>$tonton,
        																	  'tontons' =>$tontons));
    }
}
