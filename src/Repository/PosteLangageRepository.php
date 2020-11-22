<?php

namespace App\Repository;

use App\Entity\PosteLangage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PosteLangage|null find($id, $lockMode = null, $lockVersion = null)
 * @method PosteLangage|null findOneBy(array $criteria, array $orderBy = null)
 * @method PosteLangage[]    findAll()
 * @method PosteLangage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PosteLangageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PosteLangage::class);
    }

    // /**
    //  * @return PosteLangage[] Returns an array of PosteLangage objects
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
    public function findOneBySomeField($value): ?PosteLangage
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
