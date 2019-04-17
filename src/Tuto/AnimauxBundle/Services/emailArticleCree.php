<?php
namespace Tuto\AnimauxBundle\Services;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class emailArticleCree
{
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function emailArticleCree($animal)
    {
                $message = \Swift_Message::newInstance()
                        ->setSubject("Article créé: " .$animal->getTitre())
                        ->setFrom("contact@web-city.fr")
                        ->setTo("alexandre.houriez@yahoo.fr")
                        ->setCharset('utf-8')
                        ->setContentType('text/html')
                        ->setBody($this->container->get('templating')->render('TutoAnimauxBundle:Mail:mailCree.html.twig', array('animal'=>$animal)));
                         
                $this->container->get('mailer')->send($message);
    }
}

