<?php

namespace App\Entity;

use App\Repository\WorldRepository;
use App\Traits\TaggableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity(repositoryClass=WorldRepository::class)
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "api_world_show",
 *          parameters = { "id" = "expr(object.getId())" }
 *      )
 * )
 */
class World
{
    use TaggableTrait {
        TaggableTrait::__construct as private __taggableTraitConstruct;
    }
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=GameSystem::class, mappedBy="world")
     */
    private $gameSystems;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function __construct()
    {
        $this->__taggableTraitConstruct();
        $this->gameSystems = new ArrayCollection();
    }

    public function getAllTags()
    {
        $allTags = array_merge(
            $this->getTags()->toArray(),
        );

        $allGameSystemsTags = $this->getGameSystems()->map(function ($value) {
            return $value->getAllTags();
        })->toArray();

        foreach ($allGameSystemsTags as $gameSystemsTags) {
            $allTags = array_merge(
                $allTags,
                $gameSystemsTags,
            );
        }

        return $allTags;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

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
            $gameSystem->setWorld($this);
        }

        return $this;
    }

    public function removeGameSystem(GameSystem $gameSystem): self
    {
        if ($this->gameSystems->removeElement($gameSystem)) {
            // set the owning side to null (unless already changed)
            if ($gameSystem->getWorld() === $this) {
                $gameSystem->setWorld(null);
            }
        }

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
}
