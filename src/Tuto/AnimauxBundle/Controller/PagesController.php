<?php

namespace Tuto\AnimauxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Tuto\AnimauxBundle\Entity\Contact;
use Tuto\AnimauxBundle\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;

class PagesController extends Controller
{

    public function contactAction(Request $request){
    	$em=$this->getDoctrine()->getManager();

        $contact=new Contact() ;
     
        $form=$this->createForm(new ContactType(), $contact);

        /*$request=$this->getRequest();*/
        if($request->isMethod('POST')){
            $form->bind($request);

            if ($form->isSubmitted() && $form->isValid() ){
                $contact=$form->getData();

                //$animal->getImage()->Upload();

                $contact->setObjet($this->getRequest()->request->get('objet'));
                $contact->setDate(new \DateTime());
                $em->persist($contact);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info','Message bien envoyé!');

                //ici le service qui envoie l email quand un objet contact et hydraté
                //$this->container->get('emailContact')->emailContact($contact);

                return $this->redirect($this->generateUrl("contact"));
            }
        }

        return $this->render('TutoAnimauxBundle:Pages:contact.html.twig', array('form' => $form->createView()));
    }





}