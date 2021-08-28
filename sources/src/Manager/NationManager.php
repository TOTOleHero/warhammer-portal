<?php

namespace App\Manager;

use App\Entity\GameSystem;
use App\Entity\Nation;
use App\Entity\UnitGeneric;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

use function Symfony\Component\String\u;

class NationManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * find nation of unit
     */
    public function findByUnitGeneric($unitGenericId)
    {
        if($unitGenericId instanceof UnitGeneric)
        {
            $unitGenericId = $unitGenericId->getId();
        }

        return $this->entityManager->createQueryBuilder()
        ->select('n')
        ->from(Nation::class,'n')
        ->join('n.unitGenerics','u')
        ->where('u.id = :unitGenericId')
        ->setParameter(':unitGenericId',Uuid::fromString($unitGenericId)->toBinary())
        ->getQuery()
        ->execute();
    }

    /**
     * find nation by gamesystem
     */
    public function findByGamesSystem($gameSystemId)
    {
        if($gameSystemId instanceof GameSystem)
        {
            $gameSystemId = $gameSystemId->getId();
        }

        return $this->entityManager->createQueryBuilder()
        ->select('n')
        ->from(Nation::class,'n')
        ->join('n.unitGenerics','u')
        ->join('u.unitGameSystems','ugs')
        ->join('ugs.gameSystem','gs')
        ->where('gs.id = :gameSystemId')
        ->setParameter(':gameSystemId',$gameSystemId)
        ->getQuery()
        ->execute();
    }
}