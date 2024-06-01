<?php

namespace App\Manager;

use App\Entity\Profile;
use Doctrine\ORM\EntityManagerInterface;

class ProfileManager
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
        ->from(Profile::class, 'o')
        ->getQuery()
        ->getSingleScalarResult();
    }
}
