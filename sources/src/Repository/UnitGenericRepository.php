<?php

namespace App\Repository;

use App\Entity\Nation;
use App\Entity\UnitGeneric;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UnitGeneric|null find($id, $lockMode = null, $lockVersion = null)
 * @method UnitGeneric|null findOneBy(array $criteria, array $orderBy = null)
 * @method UnitGeneric[]    findAll()
 * @method UnitGeneric[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UnitGenericRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UnitGeneric::class);
    }

    public function findByNation($nationId)
    {
        if ($nationId instanceof Nation) {
            $nationId = $nationId->getId();
        }

        return $this->createQueryBuilder('ug')
            ->join('ug.nations', 'n')
            ->addSelect('n')
            ->where('n.id = :nation')
            ->setParameter(':nation', $nationId)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return UnitGeneric[] Returns an array of UnitGeneric objects
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
    public function findOneBySomeField($value): ?UnitGeneric
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
