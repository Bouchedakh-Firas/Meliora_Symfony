<?php

namespace App\Repository;

use App\Entity\Aliment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Aliment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Aliment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Aliment[]    findAll()
 * @method Aliment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlimentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Aliment::class);
    }
    /**
     * @return Aliment[] Returns an array of Aliment objects
     */


    public function findByLibelle($value)
    {
        return $this->createQueryBuilder('aliment')
            ->andWhere('aliment.libelle like :val')
            ->setParameter('val', '%'.$value.'%')
            ->getQuery()
            ->getResult()
            ;
    }



    /**
     * @return String[] Returns an array of Aliment objects
     */
    public function getLibelle()
    {
        return $this->createQueryBuilder('aliment')
            ->select('aliment.libelle')
            //  ->orderBy('aliment.libelle')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return float[] Returns an array of Aliment objects
     */

    public function getCalorie()
    {
        return $this->createQueryBuilder('aliment')
            ->select('aliment.calorie')
            // ->orderBy('aliment.libelle')
            ->getQuery()
            ->getResult()
            ;
    }


    // /**
    //  * @return Aliment[] Returns an array of Aliment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Aliment
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
