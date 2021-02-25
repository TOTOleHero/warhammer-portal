<?php

namespace App\Entity;

use App\Repository\ExternalLinkRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExternalLinkRepository::class)
 */
class ExternalLink
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $href;

    /**
     * @ORM\ManyToOne(targetEntity=ExternalLinkCategory::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHref(): ?string
    {
        return $this->href;
    }

    public function setHref(string $href): self
    {
        $this->href = $href;

        return $this;
    }

    public function getCategory(): ?ExternalLinkCategory
    {
        return $this->category;
    }

    public function setCategory(?ExternalLinkCategory $category): self
    {
        $this->category = $category;

        return $this;
    }
}
