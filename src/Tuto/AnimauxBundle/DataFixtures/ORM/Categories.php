<?php

namespace Tuto\AnimauxBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Tuto\AnimauxBundle\Entity\Categorie;

class Categories implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $noms = array('Symfony', 'Doctrine', 'Twig');

    foreach ($noms as $i => $nom) {
      // On crée la catégorie
      $liste_categories[$i] = new Categorie();
      $liste_categories[$i]->setNom($nom);

      // On la persiste
      $manager->persist($liste_categories[$i]);
    }

    // On déclenche l'enregistrement
    $manager->flush();
  }
}
