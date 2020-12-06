<?php

namespace App\Repository;

use App\Entity\ExternalLinkCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExternalLinkCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExternalLinkCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExternalLinkCategory[]    findAll()
 * @method ExternalLinkCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExternalLinkCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExternalLinkCategory::class);
    }

    // /**
    //  * @return ExternalLinkCategory[] Returns an array of ExternalLinkCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ExternalLinkCategory
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
