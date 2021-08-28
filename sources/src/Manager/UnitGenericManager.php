<?php

namespace App\Manager;

use App\Entity\GameSystem;
use App\Entity\Nation;
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


    public function findByNationAndGameSystem($nationId,$gameSystemId)
    {
        if($nationId instanceof Nation)
        {
            $nationId = $nationId->getId();
        }
        if($gameSystemId == null)
        {
            return $this->entityManager->getRepository(UnitGeneric::class)->findByNation($nationId);
        }
        if($gameSystemId instanceof GameSystem)
        {
            $gameSystemId = $gameSystemId->getId();
        }
        
        return $this->entityManager->createQueryBuilder()
        ->select('u')
        ->from(UnitGeneric::class,'u')
        ->join('u.nations','n')
        ->join('u.unitGameSystems','ugs')
        ->join('ugs.gameSystem','gs')
        ->where('n.id = :nationId')
        ->andWhere('gs.id = :gameSystemId')
        ->setParameter(':nationId',$nationId)
        ->setParameter(':gameSystemId',$gameSystemId)
        ->getQuery()
        ->execute();
    }
}