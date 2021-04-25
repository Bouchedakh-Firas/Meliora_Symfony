<?php

namespace App\Repository;

use App\Entity\Video;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Scalar\String_;

/**
 * @method Video|null find($id, $lockMode = null, $lockVersion = null)
 * @method Video|null findOneBy(array $criteria, array $orderBy = null)
 * @method Video[]    findAll()
 * @method Video[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Video::class);
    }

    /**
     * @return int[] returns an array of video likes
     */
    public function getLikes(){
        return $this->createQueryBuilder('video')
            ->select('video.nbLikes')
            ->getQuery()
            ->getResult()
            ;
    }
    /**
     * @return int[] returns an array of video likes
     */
    public function getDislikes(){
        return $this->createQueryBuilder('video')
            ->select('video.nbDislikes')
            ->getQuery()
            ->getResult()
            ;
    }
    /**
     * @return String[] returns an array of video likes
     */
    public function getTitres(){
        return $this->createQueryBuilder('video')
            ->select('video.titre')
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Video[] Returns an array of Video objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Video
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
