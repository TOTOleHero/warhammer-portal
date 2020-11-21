<?php

namespace App\Entity;

use App\Repository\WorldRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;
use Symfony\Component\Uid\Uuid;
use JMS\Serializer\Annotation as JMS;
use Hateoas\Configuration\Annotation as Hateoas;

use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

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
    /**
     * @ORM\Id
     * @JMS\Type("string")
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidV4Generator::class)

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
        $this->gameSystems = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
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
