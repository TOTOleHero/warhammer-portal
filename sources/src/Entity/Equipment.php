<?php

namespace App\Entity;

use App\Repository\EquipmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EquipmentRepository::class)
 */
class Equipment
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
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=GameSystem::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $gameSystem;

    /**
     * @ORM\ManyToMany(targetEntity=Equipment::class)
     */
    private $relatedEquipments;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    public function __construct()
    {
        $this->relatedEquipments = new ArrayCollection();
    }


    public function __toString()
    {
        return $this->getName();
    }

    public function getId(): ?int
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

        return $this;
    }

    public function getGameSystem(): ?GameSystem
    {
        return $this->gameSystem;
    }

    public function setGameSystem(?GameSystem $gameSystem): self
    {
        $this->gameSystem = $gameSystem;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getRelatedEquipments(): Collection
    {
        return $this->relatedEquipments;
    }

    public function addRelatedEquipment(self $relatedEquipment): self
    {
        if (!$this->relatedEquipments->contains($relatedEquipment)) {
            $this->relatedEquipments[] = $relatedEquipment;
        }

        return $this;
    }

    public function removeRelatedEquipment(self $relatedEquipment): self
    {
        $this->relatedEquipments->removeElement($relatedEquipment);

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
