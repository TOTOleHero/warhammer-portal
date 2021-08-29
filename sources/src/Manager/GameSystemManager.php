<?php

namespace App\Manager;

use App\Entity\GameSystem;
use App\Entity\Nation;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

use function Symfony\Component\String\u;

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
        ->from(GameSystem::class,'o')
        ->getQuery()
        ->getSingleScalarResult();
    }


}