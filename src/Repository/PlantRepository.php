<?php

namespace App\Repository;

use App\Entity\Plant;


use App\Entity\PlantSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Plant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Plant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Plant[]    findAll()
 * @method Plant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Plant::class);
    }

     /**
     * @return Query
      */
    public function findAllVisibleQuery(PlantSearch $search): Query
    {
       $query=$this->findVisibleQuery();

       if($search->getMaladie()){
           $query = $query
               ->where('p.maladie >= :maladie')
               ->setParameter('maladie',$search->getMaladie());
       }
       return $query->getQuery();
    }


    public function  findVisibleQuery(): QueryBuilder{
        return $this->createQueryBuilder('p');
    }

    /*
    public function findOneBySomeField($value): ?Plant
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
