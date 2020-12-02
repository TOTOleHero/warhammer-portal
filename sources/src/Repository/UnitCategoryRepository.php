<?php

namespace App\Repository;

use App\Entity\UnitCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UnitCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method UnitCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method UnitCategory[]    findAll()
 * @method UnitCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UnitCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UnitCategory::class);
    }

    // /**
    //  * @return UnitCategory[] Returns an array of UnitCategory objects
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
    public function findOneBySomeField($value): ?UnitCategory
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
