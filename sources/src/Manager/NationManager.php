<?php

namespace App\Manager;

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

    public function findByUnitGeneric($unitGenericId)
    {
        return $this->entityManager->createQueryBuilder()
        ->select('n')
        ->from(Nation::class,'n')
        ->join('n.unitGenerics','u')
        ->where('u.id = :unitGenericId')
        ->setParameter(':unitGenericId',Uuid::fromString($unitGenericId)->toBinary())
        ->getQuery()
        ->execute();
    }
}