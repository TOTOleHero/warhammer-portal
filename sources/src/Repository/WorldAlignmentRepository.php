<?php

namespace App\Repository;

use App\Entity\WorldAlignment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WorldAlignment|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorldAlignment|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorldAlignment[]    findAll()
 * @method WorldAlignment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorldAlignmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorldAlignment::class);
    }

    // /**
    //  * @return WorldAlignment[] Returns an array of WorldAlignment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WorldAlignment
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
