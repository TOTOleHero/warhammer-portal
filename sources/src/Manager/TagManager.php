<?php

namespace App\Manager;

use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;

class TagManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function loadOrCreate($tag)
    {
        $tagRepository = $this->entityManager->getRepository(Tag::class);

        $tagObject = $tagRepository->find($tag);

        if (null === $tagObject) {
            $tagObject = new Tag($tag);
            $this->entityManager->persist($tagObject);
            $this->entityManager->flush();
            $this->entityManager->refresh($tagObject);
        }

        return $tagObject;
    }
}
