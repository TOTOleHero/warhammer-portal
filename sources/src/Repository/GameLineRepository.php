<?php

namespace App\Repository;

use App\Entity\GameLine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GameLine|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameLine|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameLine[]    findAll()
 * @method GameLine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameLineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameLine::class);
    }

    // /**
    //  * @return GameLine[] Returns an array of GameLine objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GameLine
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
