<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\ORM\Mapping as ORM;
use function Symfony\Component\String\u;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="string", length=255)
     */
    private $id;

    public function __construct($id = null)
    {
        $this->setId($id);
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = u($id)->snake();

        return $this;
    }

    public function __toString()
    {
        return $this->getId();
    }
}
