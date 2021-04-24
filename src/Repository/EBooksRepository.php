<?php

namespace App\Repository;

use App\Entity\EBooks;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EBooks|null find($id, $lockMode = null, $lockVersion = null)
 * @method EBooks|null findOneBy(array $criteria, array $orderBy = null)
 * @method EBooks[]    findAll()
 * @method EBooks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EBooksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EBooks::class);
    }

    // /**
    //  * @return EBooks[] Returns an array of EBooks objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EBooks
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
