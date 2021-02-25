<?php

namespace App\Manager;

use App\Entity\UnitGeneric;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

use function Symfony\Component\String\u;

class UnitGenericManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findByNationId($nationsId)
    {
        return $this->entityManager->createQueryBuilder()
        ->select('u')
        ->from(UnitGeneric::class,'u')
        ->join('u.nations','n')
        ->where('n.id = :nationId')
        ->setParameter(':nationId',$nationsId)
        ->getQuery()
        ->execute();
    }
}