<?php

namespace App\Manager;

use App\Entity\GameSystem;
use Doctrine\ORM\EntityManagerInterface;

class GameSystemManager
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
        ->from(GameSystem::class, 'o')
        ->getQuery()
        ->getSingleScalarResult();
    }
}
