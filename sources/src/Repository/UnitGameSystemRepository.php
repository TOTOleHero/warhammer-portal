<?php

namespace App\Repository;

use App\Entity\UnitGameSystem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UnitGameSystem|null find($id, $lockMode = null, $lockVersion = null)
 * @method UnitGameSystem|null findOneBy(array $criteria, array $orderBy = null)
 * @method UnitGameSystem[]    findAll()
 * @method UnitGameSystem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UnitGameSystemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UnitGameSystem::class);
    }

    // /**
    //  * @return UnitGameSystem[] Returns an array of UnitGameSystem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UnitGameSystem
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
