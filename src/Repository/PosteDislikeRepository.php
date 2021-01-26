<?php

namespace App\Repository;

use App\Entity\PosteDislike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PosteDislike|null find($id, $lockMode = null, $lockVersion = null)
 * @method PosteDislike|null findOneBy(array $criteria, array $orderBy = null)
 * @method PosteDislike[]    findAll()
 * @method PosteDislike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PosteDislikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PosteDislike::class);
    }

    // /**
    //  * @return PosteDislike[] Returns an array of PosteDislike objects
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
    public function findOneBySomeField($value): ?PosteDislike
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
