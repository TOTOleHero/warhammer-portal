<?php

namespace App\Manager;

use App\Entity\ExternalLinkCategory;
use Doctrine\ORM\EntityManagerInterface;
use function Symfony\Component\String\u;

class ExternalLinkCategoryManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function loadOrCreate($externalLinkCategory)
    {
        $externalLinkCategoryRepository = $this->entityManager->getRepository(ExternalLinkCategory::class);

        $externalLinkCategoryObject = $externalLinkCategoryRepository->find(u($externalLinkCategory)->snake());

        if (null === $externalLinkCategoryObject) {
            $externalLinkCategoryObject = new ExternalLinkCategory($externalLinkCategory);
            $this->entityManager->persist($externalLinkCategoryObject);
            $this->entityManager->flush();
            $this->entityManager->refresh($externalLinkCategoryObject);
        }

        return $externalLinkCategoryObject;
    }
}
