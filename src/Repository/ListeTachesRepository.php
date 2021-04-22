<?php

namespace App\Repository;

use App\Entity\ListeTaches;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ListeTaches|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListeTaches|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListeTaches[]    findAll()
 * @method ListeTaches[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListeTachesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListeTaches::class);
    }

    // /**
    //  * @return ListeTaches[] Returns an array of ListeTaches objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ListeTaches
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
