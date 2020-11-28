<?php

namespace App\Entity;

use App\Repository\ProfileTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfileTypeRepository::class)
 */
class ProfileType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=GameSystem::class, mappedBy="profileType")
     */
    private $gameSystems;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $profileClassName;

    public function __construct()
    {
        $this->gameSystems = new ArrayCollection();
    }

    public function __toString()
    {
        return  implode(',', $this->getGameSystems()->map(function ($gs) {
            return $gs->getid();
        })->toArray());
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
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

    /**
     * @return Collection|GameSystem[]
     */
    public function getGameSystems(): Collection
    {
        return $this->gameSystems;
    }

    public function addGameSystem(GameSystem $gameSystem): self
    {
        if (!$this->gameSystems->contains($gameSystem)) {
            $this->gameSystems[] = $gameSystem;
            $gameSystem->setProfileType($this);
        }

        return $this;
    }

    public function removeGameSystem(GameSystem $gameSystem): self
    {
        if ($this->gameSystems->removeElement($gameSystem)) {
            // set the owning side to null (unless already changed)
            if ($gameSystem->getProfileType() === $this) {
                $gameSystem->setProfileType(null);
            }
        }

        return $this;
    }

    public function getProfileClassName(): ?string
    {
        return $this->profileClassName;
    }

    public function setProfileClassName(string $profileClassName): self
    {
        $this->profileClassName = $profileClassName;

        return $this;
    }
}
