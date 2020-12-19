<?php

namespace App\Entity;

use App\Repository\ExternalLinkCategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use function Symfony\Component\String\u;



/**
 * @ORM\Entity(repositoryClass=ExternalLinkCategoryRepository::class)
 */
class ExternalLinkCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;


    public function __construct($categoryName = null)
    {
        $this->setName($categoryName);
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        $this->id = u($name)->snake();
        return $this;
    }
}
