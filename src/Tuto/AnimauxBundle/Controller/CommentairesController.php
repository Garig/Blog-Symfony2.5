<?php

namespace Tuto\AnimauxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Tuto\AnimauxBundle\Entity\Animal;
use Tuto\AnimauxBundle\Entity\Commentaires;

class CommentairesController extends Controller
{
    public function recentCommentairesAction(){

            $em=$this->getDoctrine()->getManager();

            $commentaires=$em->getRepository("TutoAnimauxBundle:Commentaires")
                    //->findall();
                    ->findBy(array(), array('id' => 'desc'));

                return $this->render('TutoAnimauxBundle:Default:recentcommentaires.html.twig', array(
            'commentaires' => $commentaires,
        ));
    }
    
    public function voirCommentaire($id){
        
        $commentaire=$em->getRepository("TutoAnimauxBundle:Commentaires")->find($id);

        
        return $this->render('TutoAnimauxBundle:Default:voircommentaire.html.twig', array('commentaire'=>$commentaire,
        ));
    }
    
    public function nombreCommentaire($id){
        
        $commentaireNombre=$em->getRepository("TutoAnimauxBundle:Commentaires")
                              ->commentaireByArticle($animal);
        
        return $this->render('TutoAnimauxBundle:Default:co.html.twig', array(
                                                                                'commentaireNombre'=>$commentaireNombre
                                                                                
        ));
         
         
    }
}
