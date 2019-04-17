<?php
namespace Tuto\AnimauxBundle\Services;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class emailContact
{
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function emailContact($contact)
    {
                $message = \Swift_Message::newInstance()
                        ->setSubject("Email reçu : " .$contact->getObjet())
                        ->setFrom("contact@web-city.fr")
                        ->setTo("alexandre.houriez@yahoo.fr")
                        ->setCharset('utf-8')
                        ->setContentType('text/html')
                        ->setBody($this->container->get('templating')->render('TutoAnimauxBundle:Mail:mailContact.html.twig', array('contact'=>$contact)));
                         
                $this->container->get('mailer')->send($message);
    }
}