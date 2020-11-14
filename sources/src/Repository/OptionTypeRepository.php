<?php

namespace App\Repository;

use App\Entity\OptionType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OptionType|null find($id, $lockMode = null, $lockVersion = null)
 * @method OptionType|null findOneBy(array $criteria, array $orderBy = null)
 * @method OptionType[]    findAll()
 * @method OptionType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OptionTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OptionType::class);
    }

    // /**
    //  * @return OptionType[] Returns an array of OptionType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OptionType
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
