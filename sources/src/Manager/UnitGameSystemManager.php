<?php

namespace App\Manager;

use App\Entity\GameSystem;
use App\Entity\Nation;
use App\Entity\UnitGameSystem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

use function Symfony\Component\String\u;

class UnitGameSystemManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    

    public function countAll()
    {
        return $this->entityManager->createQueryBuilder()
        ->select('count(o.id)')
        ->from(UnitGameSystem::class,'o')
        ->getQuery()
        ->getSingleScalarResult();
    }


}