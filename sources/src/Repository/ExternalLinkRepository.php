<?php

namespace App\Repository;

use App\Entity\ExternalLink;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExternalLink|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExternalLink|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExternalLink[]    findAll()
 * @method ExternalLink[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExternalLinkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExternalLink::class);
    }

    // /**
    //  * @return ExternalLink[] Returns an array of ExternalLink objects
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
    public function findOneBySomeField($value): ?ExternalLink
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
