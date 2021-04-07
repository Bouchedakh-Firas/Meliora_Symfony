<?php

namespace App\Repository;

use App\Entity\PlanningUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PlanningUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlanningUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlanningUser[]    findAll()
 * @method PlanningUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanningUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlanningUser::class);
    }

    // /**
    //  * @return PlanningUser[] Returns an array of PlanningUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PlanningUser
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
