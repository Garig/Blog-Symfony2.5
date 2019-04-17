<?php

namespace Ecommerce\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ecommerce\EcommerceBundle\Entity\Produits;

class TestController extends Controller
{
    public function ajoutAction()
    {
    	$produit=new Produits();

        return $this->render('EcommerceBundle:Produits/layout:index.html.twig');
    }
}