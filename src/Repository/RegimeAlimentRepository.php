<?php

namespace App\Repository;

use App\Entity\RegimeAliment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RegimeAliment|null find($id, $lockMode = null, $lockVersion = null)
 * @method RegimeAliment|null findOneBy(array $criteria, array $orderBy = null)
 * @method RegimeAliment[]    findAll()
 * @method RegimeAliment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegimeAlimentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RegimeAliment::class);
    }

    // /**
    //  * @return RegimeAliment[] Returns an array of RegimeAliment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RegimeAliment
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
