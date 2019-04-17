<?php
namespace Tuto\AnimauxBundle\Services;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class emailArticleSupprime 
{
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function emailArticleSupprime($animal)
    {
                $message = \Swift_Message::newInstance()
                        ->setSubject("Article supprimé: " .$animal->getTitre())
                        ->setFrom("contact@web-city.fr")
                        ->setTo("alexandre.houriez@yahoo.fr")
                        ->setCharset('utf-8')
                        ->setContentType('text/html')
                        ->setBody($this->container->get('templating')->render('TutoAnimauxBundle:Mail:mailSupprime.html.twig', array('animal'=>$animal)));
                         
                $this->container->get('mailer')->send($message);
    }
}

