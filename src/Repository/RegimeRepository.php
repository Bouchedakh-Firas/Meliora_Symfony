<?php

namespace App\Repository;

use App\Entity\Regime;
use App\Form\Regime1Type;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Regime|null find($id, $lockMode = null, $lockVersion = null)
 * @method Regime|null findOneBy(array $criteria, array $orderBy = null)
 * @method Regime[]    findAll()
 * @method Regime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Regime::class);
    }
    public function findRegimeparID($description){
        return $this->createQueryBuilder('regime')
            ->where('regime.description LIKE :description')
            ->setParameter('description', '%'.$description.'%')
            ->getQuery()
            ->getResult();
    }
//    function SearchOffre($libelle){
//        $query=$this->getEntityManager()->createQuery("select e from Entity\Regime e where e.type LIKE '%$libelle%'");
//        return $query->getResult();
//
//    }
    // /**
    //  * @return Regime[] Returns an array of Regime objects
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
    public function findOneBySomeField($value): ?Regime
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
