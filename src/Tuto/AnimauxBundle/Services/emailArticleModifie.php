<?php
namespace Tuto\AnimauxBundle\Services;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class emailArticleModifie
{
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function emailArticleModifie($animal)
    {
                $message = \Swift_Message::newInstance()
                        ->setSubject("Article modifié: " .$animal->getTitre())
                        ->setFrom("contact@web-city.fr")
                        ->setTo("alexandre.houriez@yahoo.fr")
                        ->setCharset('utf-8')
                        ->setContentType('text/html')
                        ->setBody($this->container->get('templating')->render('TutoAnimauxBundle:Mail:mailModifie.html.twig', array('animal'=>$animal)));
                         
                $this->container->get('mailer')->send($message);
    }
}

