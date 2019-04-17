<?php

namespace Tuto\AnimauxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Tuto\AnimauxBundle\Entity\Categorie;
use Tuto\AnimauxBundle\Form\CategorieType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class CategoriesController extends Controller
{
    public function menuAction()
    {
        $em=$this->getDoctrine()->getManager();
        
        $categories=$em->getRepository('TutoAnimauxBundle:Categorie')->findAll();
                
        return $this->render('TutoAnimauxBundle:Default:navigation.html.twig', array('categories'=>$categories));
    }
    
    
          /**
   * @Security("has_role('ROLE_ADMIN')")
   */
    public function ajouterCategorieAction(){
    	$em=$this->getDoctrine()->getManager();
        $categories=$em->getRepository('TutoAnimauxBundle:Categorie')->findAll();

        $categorie=new Categorie() ;
     
        $form=$this->createForm(new CategorieType(), $categorie);

        $request=$this->getRequest();
        if($request->isMethod('POST')){
            $form->bind($request);

            if ($form->isValid()){
                $categorie=$form->getData();

                $em->persist($categorie);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info','Catégorie bien ajoutée !');

                return $this->redirect($this->generateUrl("tuto_animaux_ajouterCategorie"));
            }
        }

        return $this->render('TutoAnimauxBundle:Default:ajouterCategorie.html.twig', array('form' => $form->createView(),
                                                                                           'categories'=> $categories
        ));
    }
    
      /**
   * @Security("has_role('ROLE_ADMIN')")
   */
    public function editerCategorieAction(Categorie $categorie){
        $em=$this->getDoctrine()->getManager();
        $categories=$em->getRepository('TutoAnimauxBundle:Categorie')->findAll();

        $form=$this->createForm(new CategorieType(), $categorie);

        $request=$this->getRequest();
        if($request->isMethod('POST')){
            $form->bind($request);

            if ($form->isValid()){
                $categorie=$form->getData();
                //$em->persist($categorie);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info','Catégorie bien modifiée !');

                return $this->redirect(
                    $this->generateUrl("tuto_animaux_ajouterCategorie")
                );
            }
        }

        return $this->render('TutoAnimauxBundle:Default:editerCategorie.html.twig', array(
            'categories'=> $categories,
            'id'   => $categorie->getId(),
            'form' => $form->createView(),
        ));
    }

  /**
   * @Security("has_role('ROLE_ADMIN')")
   */
    public function supprimerCategorieAction(Categorie $categorie){
        $em=$this->getDoctrine()->getManager();

        $em->remove($categorie);
        $em->flush();

        $this->get('session')->getFlashBag()->add('info','Categorie bien supprimé !');


        return $this->redirect($this->generateUrl("tuto_animaux_ajouterCategorie"));

    }
}
