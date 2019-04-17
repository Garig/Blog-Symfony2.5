<?php
namespace Tuto\AnimauxBundle\Services;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class nouveauCommentaire 
{
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function nouveauCommentaire($commentaire)
    {
                $message = \Swift_Message::newInstance()
                        ->setSubject("Nouveau commentaire : " .$commentaire->getAuteur())
                        ->setFrom("contact@web-city.fr")
                        ->setTo("alexandre.houriez@yahoo.fr")
                        ->setCharset('utf-8')
                        ->setContentType('text/html')
                        ->setBody($this->container->get('templating')->render('TutoAnimauxBundle:Mail:mailComment.html.twig', array('commentaire'=>$commentaire)));
                         
                $this->container->get('mailer')->send($message);
    }
}

