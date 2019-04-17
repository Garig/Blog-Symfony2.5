<?php

namespace Tuto\AnimauxBundle\Entity;

class CommentairesRepository extends \Doctrine\ORM\EntityRepository
{
    public function byAnimal($animal)
    {
         $qb = $this->createQueryBuilder('c')//l alias correspond a commentaires car on est dans commentaires
                    ->select('c')//on selectionne produits
                    ->where('c.animal = :animal')//heuresement que j avais mis un s à u.categories//on fait correspondre categorie de produits à la catégorie passé en paramètre
                    ->orderBy('c.id')//tu peux mettre 'u.nom' ça sera par ordre alphabétique
                    ->setParameter('animal', $animal);//obligatoire pour spécifier le paramètre
        return $qb->getQuery()->getResult();
    }
    
    public function commentaireByArticle($animal)
    {
        $qb = $this->createQueryBuilder('c')
                   ->select('COUNT(c)')
                   ->where('c.animal = :animal')
                   ->setParameter('animal', $animal);
        return $qb->getQuery()->getSingleScalarResult();
                   
    }
    

}
