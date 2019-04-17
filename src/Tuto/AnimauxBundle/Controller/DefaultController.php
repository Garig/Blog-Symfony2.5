<?php

namespace Tuto\AnimauxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Tuto\AnimauxBundle\Entity\Animal;
use Tuto\AnimauxBundle\Entity\Categorie;
use Tuto\AnimauxBundle\Form\AnimalType;
use Tuto\AnimauxBundle\Entity\Commentaires;
use Tuto\AnimauxBundle\Form\CommentairesType;
use Tuto\AnimauxBundle\Form\RechercheType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    public function indexAction(Categorie $categorie=null)
    {
        $em=$this->getDoctrine()->getManager();
        
        $categories=$em->getRepository('TutoAnimauxBundle:Categorie')->findAll();
        
        if($categorie!=null)
        {
            $findAnimaux=$em->getRepository('TutoAnimauxBundle:Animal')->byCategorie($categorie);
        }
        else
        {
            $findAnimaux=$em->getRepository('TutoAnimauxBundle:Animal')->findBy(array(), array('id' => 'desc'));
        }
        
        $animaux  = $this->get('knp_paginator')->paginate(
        $findAnimaux,/*la requete*/
        $this->getRequest()->query->get('page', 1)/*page number*/,
        9/*limit per page*/
        );

        return $this->render('TutoAnimauxBundle:Default:index.html.twig', array('animaux'=>$animaux,
                                                                           'categories'=>$categories,
                                                                           'categorie'=>$categorie,                                                                 
         ));
    }

  /**
   * @Security("has_role('ROLE_ADMIN')")
   */
    public function ajouterAction(Request $request){
    	$em=$this->getDoctrine()->getManager();
        $articles=$em->getRepository('TutoAnimauxBundle:Animal')->findBy(array(), array('id' => 'desc'));

        $animal=new Animal() ;
     
        $form=$this->createForm(new AnimalType(), $animal);

        /*$request=$this->getRequest();*/
        if($request->isMethod('POST')){
            $form->bind($request);

            if ($form->isValid()){
                $animal=$form->getData();

                //$animal->getImage()->Upload();

                $em->persist($animal);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info','Article bien ajouté !');
                
                //ici le service qui envoie l email quand un article a été créé
                $this->container->get('emailArticleCree')->emailArticleCree($animal);

                return $this->redirect($this->generateUrl("tuto_animaux_homepage"));
            }
        }

        return $this->render('TutoAnimauxBundle:Default:ajouter.html.twig', array('form' => $form->createView(),
                                                                                  'articles'=>$articles
        ));
    }
   

  /**
   * @Security("has_role('ROLE_ADMIN')")
   */
    public function editerAction(Animal $animal, Request $request){
        $em=$this->getDoctrine()->getManager();
        $articles=$em->getRepository('TutoAnimauxBundle:Animal')->findBy(array(), array('id' => 'desc'));

        $form=$this->createForm(new AnimalType(), $animal);

        /*$request=$this->getRequest();*/
        if($request->isMethod('POST')){
            $form->bind($request);

            if ($form->isValid()){
                $animal=$form->getData();
                //$em->persist($animal);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info','Article bien modifié !');

                //ici le service qui envoie l email quand un article a été modifié
                $this->container->get('emailArticleModifie')->emailArticleModifie($animal);

                return $this->redirect($this->generateUrl("tuto_animaux_voir", array('slug'=>$animal->getSlug() ))
                );
            }
        }

        return $this->render('TutoAnimauxBundle:Default:editer.html.twig', array(
            'id'   => $animal->getId(),
            'form' => $form->createView(),
            'articles'=>$articles
        ));
    }

  /**
   * @Security("has_role('ROLE_ADMIN')")
   */
    public function supprimerAction(Animal $animal){
        $em=$this->getDoctrine()->getManager();

        $em->remove($animal);
        $em->flush();

        $this->get('session')->getFlashBag()->add('info','Article bien supprimé !');

                //ici le service qui envoie l email quand un article a été supprimé
                $this->container->get('emailArticleSupprime')->emailArticleSupprime($animal);

        return $this->redirect($this->generateUrl("articles_index"));

    }

    public function voirAction(Animal $animal, Request $request){
        
        if (!$animal)
        {
            throw $this->createNotFoundException ('La page n\'a pas été trouvé');
        }
        
        $uri='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        $em=$this->getDoctrine()->getManager();
        $commentaires=$em->getRepository('TutoAnimauxBundle:Commentaires')
                         ->byAnimal($animal);
        
        $commentaireNombre=$em->getRepository("TutoAnimauxBundle:Commentaires")
                              ->commentaireByArticle($animal);
        

        $commentaire=new Commentaires() ;
     
        $form=$this->createForm(new CommentairesType(), $commentaire);

        /*$request=$this->getRequest();*/
        if($request->isMethod('POST')){
            $form->bind($request);

            if ($form->isValid()){
                $commentaire=$form->getData();
                $commentaire->setAnimal($animal);
                $em->persist($commentaire);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info','Commentaire bien ajouté !');

                //ici le service qui envoie l email quand un commentaire a été créé
                //$this->container->get('nouveauCommentaire')->nouveauCommentaire($commentaire);

                return $this->redirect($this->generateUrl("tuto_animaux_voir", array('slug'=>$animal->getSlug())).'#comment'.$commentaire->getId());
            }
        }

        return $this->render('TutoAnimauxBundle:Default:voir.html.twig', array('form' => $form->createView(),
                                                                                'commentaires'=>$commentaires,
                                                                                'commentaireNombre'=>$commentaireNombre,
                                                                                'animal' => $animal,
                                                                                'uri'=> $uri
        ));

    }
    
    public function articlesAdministrationAction()
    {
        $em=$this->getDoctrine()->getManager();
        $articles=$em->getRepository('TutoAnimauxBundle:Animal')->findBy(array(), array('id' => 'desc'));

        return $this->render('TutoAnimauxBundle:Default:articlesAdministration.html.twig', array('articles'=>$articles,));
        
    }

    public function categoriesAdministrationAction()
    {
        $em=$this->getDoctrine()->getManager();
        $categories=$em->getRepository('TutoAnimauxBundle:Categorie')->findBy(array(), array('id' => 'desc'));

        return $this->render('TutoAnimauxBundle:Default:categoriesAdministration.html.twig', array('categories'=>$categories,));
        
    }

    public function commentairesAdministrationAction()
    {
        $em=$this->getDoctrine()->getManager();
        $commentaires=$em->getRepository('TutoAnimauxBundle:Commentaires')->findAll();

        return $this->render('TutoAnimauxBundle:Default:commentairesAdministration.html.twig', array('commentaires'=>$commentaires,));
        
    }
    
   /**
   * @Security("has_role('ROLE_ADMIN')")
   */ 
    public function commentairesAdministrationDeleteAction(Commentaires $commentaire)
    {
        $em=$this->getDoctrine()->getManager();

        $em->remove($commentaire);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('info','Commentaire bien supprimé !');

        return $this->redirect($this->generateUrl("commentaires_index"));
    }
    

    public function recentArticlesAction(){

            $em=$this->getDoctrine()->getManager();

            $animaux=$em->getRepository("TutoAnimauxBundle:Animal")
                    //->findall();
                    ->findBy(array(), array('id' => 'desc'));

                return $this->render('TutoAnimauxBundle:Default:recentarticles.html.twig', array(
            'animaux' => $animaux,
        ));
    }
    
    public function softDelAction()
    {
        $em = $this->getDoctrine()->getManager();
        $em->getFilters()->disable('softdeleteable');
        
        $entities = $em->getRepository('TutoAnimauxBundle:Animal')->findByRemove();
        return $this->render('TutoAnimauxBundle:Default:softDel.html.twig', array(
            'entities' => $entities,
        ));
    }
    
    public function restoreAction($id) 
    {
        $em = $this->getDoctrine()->getManager();
        $em->getFilters()->disable('softdeleteable');
        
        $entity = $em->getRepository('TutoAnimauxBundle:Animal')->find($id);
        $entity->setDeletedAt(null);
        $em->persist($entity);
        $em->flush();

        $this->get('session')->getFlashBag()->add('info','Article bien restauré !');
        
        return $this->redirect($this->generateUrl('articles_index'));
    }
    
    public function rechercheAction()
    {
        $form=$this->createForm(new RechercheType());
        
        return $this->render('TutoAnimauxBundle:Recherche:recherche.html.twig', array('form'=>$form->createView()));
    }
    
    public function rechercheTraitementAction(Categorie $categorie=null) 
    {
        $form = $this->createForm(new RechercheType());
        
        if ($this->get('request')->getMethod() == 'POST')
        {
            $form->bind($this->get('request'));
            $em = $this->getDoctrine()->getManager();
            $findAnimaux = $em->getRepository('TutoAnimauxBundle:Animal')->recherche($form['recherche']->getData());
            
            $animaux  = $this->get('knp_paginator')->paginate(
            $findAnimaux,/*la requete*/
            $this->getRequest()->query->get('page', 1)/*page number*/,
            6/*limit per page*/
            );
        } 
        else 
        {
            throw $this->createNotFoundException('La page n\'existe pas.');
        }
        
        return $this->render('TutoAnimauxBundle:Default:index.html.twig', array('animaux' => $animaux,
                                                                                   'categorie' => $categorie));
    }
    
}
