<?php
//le namespace ne change pas
namespace Sdz\blogBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sdz\blogBundle\Entity\Article;//le namespace est bon ici
use Sdz\blogBundle\Entity\Image;//le namespace est bon ici
use Sdz\blogBundle\Entity\Commentaire;//le namespace est bon ici

class BlogController extends Controller {

	public function indexAction($page) 
    {
        if($page<1)
        {
            throw $this->createNotFoundException('page inexistante (page= '.$page.')');
        } 
        $em=$this->getDoctrine()->getManager();                

        $articles=$em->getRepository('blogBundle:Article')
                    ->findAll();
		return $this->render('blogBundle:Blog:index.html.twig', array('articles'=>$articles ));
	}

    public function voirAction($id)
    {

        //ici normalement je devrai récupérer les attributs de l'article au bon id
        //ba si tu veux récupérer le bon article faudrait soit mettre en dur les 3 articles
        //soit faut utiliser les repository pour aller chercher en bdd
        /*$article=array(
                'id' => 1,
                'titre' =>'Mon week end a phi phi island',
                'auteur' => 'Winzou',
                'contenu' => 'Ce week end était trop bien',
                'date' => new \Datetime()
        );
        */
        $em=$this->getDoctrine()->getManager();                

        $article=$em->getRepository('blogBundle:Article')
                    ->find($id);

        if($article===null){
            throw $this->createNotFoundException('Article[id='.$id.']inexistant.');
        }

        $liste_commentaires=$em->getRepository('blogBundle:Commentaire')
                               ->findBy(array('article'=> $article));
    
        return $this->render('blogBundle:Blog:voir.html.twig', array(
            'article'=> $article,
            'liste_commentaires'=>$liste_commentaires
            ));
    }

    public function ajouterAction()
    {
        $article = new Article();
        $article->setDate(new \Datetime());
        $article->setTitre('Le week end du 15 aout');
        $article->setAuteur('Alex');
        $article->setContenu("C était vraiment super ce week end");

        $image=new Image();
        $image->setUrl('http://symfony.com/logos/symfony_black_01.png?v=4');
        $image->setAlt('logo Symfony');
        

        $commentaire1=new Commentaire();
        $commentaire1->setAuteur('Matt');
        $commentaire1->setDate(new \DateTime());
        $commentaire1->setContenu('On veut les photos');

        $commentaire2=new Commentaire();
        $commentaire2->setAuteur('Ludovic');
        $commentaire2->setDate(new \DateTime());
        $commentaire2->setContenu('Les photos arrivent');

        $commentaire1->setArticle($article);
        $commentaire2->setArticle($article);
        $article->setImage($image);

        $em=$this->getDoctrine()->getManager();
        $em->persist($article);
        $em->persist($image);
        $em->persist($commentaire1);
        $em->persist($commentaire2);
        $em->flush();

        //ça ne fonctionnera pas le message flash car on est pas en POST ici
        //donc le message est bien enregistré en bdd et on est dirigé vers la vue ajouter c est tout
        //on récupère la requete et on la teste en une seule ligne
        //$request=get('request');
        //if($this->$request->getMethod()=='POST')
        if($this->get('request')->getMethod()=='POST')
        {
            $this->get('session')->getFlashbag()->add('notice','Article bien enregistré');
            return $this->redirect($this->generateUrl('blog_voir',array('id'=>$article->getId())) );
        }

        return $this->render('blogBundle:Blog:ajouter.html.twig');
    }

    public function modifierAction($id)
    {
                $article=array(
                'id' => 1,
                'titre' =>'Mon week end a phi phi island',
                'auteur' => 'Winzou',
                'contenu' => 'Ce week end était trop bien',
                'date' => new \Datetime()
        );

        return $this->render('blogBundle:Blog:modifier.html.twig', array('article'=> $article));
    }

    public function supprimerAction($id)
    {

                $article=array(
                'id' => 1,
                'titre' =>'Mon week end a phi phi island',
                'auteur' => 'Winzou',
                'contenu' => 'Ce week end était trop bien',
                'date' => new \Datetime()
        );
        return $this->render('blogBundle:Blog:supprimer.html.twig', array('article'=>$article));
    }

    public function menuAction($nombre)
    {
        $liste=array(
            array('id'=>2, 'titre'=>'Mon dernier weekend'),
            array('id'=>5, 'titre'=>'Sortie de Symfony'),
            array('id'=>9, 'titre'=>'Stage de développeur'),
            array('id'=>28, 'titre'=>'Logo Symfony à Cambrai'),
            array('id'=>33, 'titre'=>'Les commentaires du week end'),
            array('id'=>36, 'titre'=>'Article Image Commentaire'),
            );
        return $this->render('blogBundle:Blog:menu.html.twig', array('liste_articles'=>$liste));
    }



}



?>