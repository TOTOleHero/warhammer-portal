<?php

namespace App\Repository;

use App\Entity\Aligment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Aligment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Aligment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Aligment[]    findAll()
 * @method Aligment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AligmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Aligment::class);
    }

    // /**
    //  * @return Aligment[] Returns an array of Aligment objects
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
    public function findOneBySomeField($value): ?Aligment
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
