<?php

namespace Tuto\AnimauxBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * AnimalRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AnimalRepository extends EntityRepository
{
        public function byCategorie($categorie)
    {
         $qb = $this->createQueryBuilder('a')//l alias correspond a produits car on est dans produits
                    ->select('a')//on selectionne produits
                    ->where('a.categorie = :categorie')//heuresement que j avais mis un s à u.categories//on fait correspondre categorie de produits à la catégorie passé en paramètre
                    ->orderBy('a.id','DESC')//tu peux mettre 'u.nom' ça sera par ordre alphabétique
                    ->setParameter('categorie', $categorie);//obligatoire pour spécifier le paramètre
        return $qb->getQuery()->getResult();
    }
    
    public function findByRemove()
    {
        $qb = $this->createQueryBuilder('u')
                ->select('u')
                ->where('u.deletedAt IS NOT NULL');
        
        return $qb->getQuery()->getResult();
    }
    
    public function recherche($chaine)
    {
         $qb = $this->createQueryBuilder('u')
                    ->select('u')
                    ->where('u.titre like :chaine')
                    ->orWhere('u.description like :chaine')
                    ->orderBy('u.id','DESC')
                    ->setParameter('chaine', '%'.$chaine.'%');
        return $qb->getQuery()->getResult();
    }
    
}
