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

    /**
     * @var TagManager
     */
    protected $tagManager;

    public function __construct(EntityManagerInterface $entityManager,TagManager $tagManager)
    {
        $this->entityManager = $entityManager;
        $this->tagManager = $tagManager;
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

    public function countAll()
    {
        return $this->entityManager->createQueryBuilder()
        ->select('count(o.id)')
        ->from(Nation::class,'o')
        ->getQuery()
        ->getSingleScalarResult();
    }

    /**
     * load or create Nation
     */
    public function loadOrCreate($nationCode,$nationName)
    {
        $nation = $this->entityManager->getRepository(Nation::class)->find($nationCode);
        if($nation == null)
        {
             $nation = new Nation();
            $nation->setName($nationName);
            $nation->setId($nationCode);
            $nation->addTag($this->tagManager->loadOrCreate($nation->getName()));
            $this->entityManager->persist($nation);
            $this->entityManager->refresh($nation);
        }
        return $nation;
    }

}