<?php

namespace App\Manager;

use App\Entity\UnitGameSystem;
use Doctrine\ORM\EntityManagerInterface;

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
        ->from(UnitGameSystem::class, 'o')
        ->getQuery()
        ->getSingleScalarResult();
    }
}
