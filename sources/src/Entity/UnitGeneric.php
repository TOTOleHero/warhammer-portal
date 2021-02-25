<?php

namespace App\Entity;

use App\Exception\GameSystemNotFoundException;
use App\Repository\UnitGenericRepository;
use App\Traits\TaggableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Hateoas\Configuration\Annotation as Hateoas;
use Hateoas\Configuration\Metadata\ClassMetadataInterface;
use Hateoas\Configuration\Relation;
use Hateoas\Configuration\Route;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;
use Symfony\Component\Uid\Uuid;

/**
 * @Gedmo\TranslationEntity(class="App\Entity\UnitGenericTranslation")
 * @ORM\Entity(repositoryClass=UnitGenericRepository::class)
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "api_unitGeneric_show",
 *          parameters = { "id" = "expr(object.getId())" }
 *      )
 * )
 * @Hateoas\Relation(
 *      "race",
 *      href = @Hateoas\Route(
 *          "api_race_show",
 *          parameters = { "id" = "expr(object.getRace().getId())" }
 *      ),
 *      exclusion = @Hateoas\Exclusion(excludeIf = "expr(null === object.getRace())")
 * )
  * @Hateoas\Relation(
 *      "unitGameSystems",
 *      href = @Hateoas\Route(
 *          "api_unitGameSystem_by_unitGeneric",
 *          parameters = { "unitGenericId" = "expr(object.getId())" }
 *      ),
 *      exclusion = @Hateoas\Exclusion(excludeIf = "expr([] === object.getUnitGameSystems())")
 * )

  * @Hateoas\Relation(
 *      "nations",
 *      href = @Hateoas\Route(
 *          "api_nation_by_unitGeneric",
 *          parameters = { "unitGenericId" = "expr(object.getId())" }
 *      ),
 *      exclusion = @Hateoas\Exclusion(excludeIf = "expr([] === object.getNations())")
 * )
 */
class UnitGeneric
{
    use TaggableTrait {
        TaggableTrait::__construct as private __taggableTraitConstruct;
    }
    /**
     * @ORM\Id
     * @JMS\Type("string")
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidV4Generator::class)
     */
    private $id;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=255)
     */
    private $baseName;

    /**
     * @JMS\Exclude()
     * @ORM\ManyToMany(targetEntity=Nation::class, inversedBy="unitGenerics")
     */
    private $nations;

    /**
     * @JMS\Exclude() 
     * @ORM\ManyToOne(targetEntity=Race::class)

     */
    private $race;

    /**
     * @JMS\Exclude() 
     * @ORM\OneToMany(targetEntity=UnitGameSystem::class, mappedBy="unitGeneric")
     */
    private $unitGameSystems;

    public function __construct()
    {
        $this->__taggableTraitConstruct();
        $this->unitGameSystems = new ArrayCollection();
        $this->nations = new ArrayCollection();
    }

    public function getAllTags()
    {
        $allTags = array_merge(
            $this->getTags()->toArray(),
            $this->getRace()->getAllTags(),
        );

        foreach($this->getNations() as $nation)
        {
            $allTags = array_merge($allTags,$nation->getAllTags());
        }

        return $allTags;
    }




    public function getGameSystem($gameSystemId): GameSystem
    {
        foreach ($this->getGameSystems() as $gameSystem) {
            if ($gameSystemId == $gameSystem->getId()) {
                return $gameSystem;
            }
        }

        throw new GameSystemNotFoundException(sprintf('No GameSystem exit with gameSystem "%s"', $gameSystemId));
    }

    /**
     * @return Collection|GameSystem[]
     */
    public function getGameSystems(): array
    {
        $gameSystems = [];
        foreach ($this->getUnitGameSystems() as $unitGameSystems) {
            $gameSystemId = $unitGameSystems->getGameSystem()->getId();

            if (!array_key_exists($gameSystemId, $gameSystems)) {
                $gameSystems[$gameSystemId] = [];
            }
            $gameSystems[$gameSystemId] = $unitGameSystems->getGameSystem();
            ksort($gameSystems);
        }

        return $gameSystems;
    }

    public function findUnitGamesSystemByGameSystemId($gameSystemId): UnitGameSystem
    {
        foreach ($this->getUnitGameSystems() as $unitGameSystem) {
            if ($unitGameSystem->getGameSystem()->getId() == $gameSystemId) {
                return $unitGameSystem;
            }
        }

        throw new GameSystemNotFoundException(sprintf('No UnitGameSystem exit with gameSystem "%s"', $gameSystemId));
    }

    /**
     * @return Collection|Profile[]
     */
    public function getAllProfilesByGameSystems(): array
    {
        //flat gamesystem array
        $profilesByGameSystems = array_map(
            function ($value) {
                return [];
            },
            $this->getGameSystems()
        );

        foreach ($this->getUnitGameSystems() as $unitGameSystem) {
            foreach ($unitGameSystem->getProfiles() as $profile) {
                $profilesByGameSystems[$profile->getGameSystem()->getId()][] = $profile;
            }
        }

        return $profilesByGameSystems;
    }

    public function __toString()
    {
        return $this->getBaseName();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getBaseName(): ?string
    {
        return $this->baseName;
    }

    public function setBaseName(string $baseName): self
    {
        $this->baseName = $baseName;

        return $this;
    }

    public function addNation(Nation $nation)
    {
        if(!$this->nations->contains($nation))
                          {
                              $this->nations->add($nation);
                          }

                          return $this;
    }


    public function removeNation(Nation $nation)
    {
        if(!$this->nations->contains($nation))
                          {
                              $this->nations->remove($nation);
                          }

                          return $this;
    }

    public function getNations()
    {
        return $this->nations;
    }
    
    public function setNations($nations): self
    {
        $this->nations = $nations;

        return $this;
    }

    public function getRace(): ?Race
    {
        return $this->race;
    }

    public function setRace(?Race $race): self
    {
        $this->race = $race;

        return $this;
    }

    /**
     * @return Collection|UnitGameSystem[]
     */
    public function getUnitGameSystems(): Collection
    {
        return $this->unitGameSystems;
    }

    public function addUnitGameSystem(UnitGameSystem $unitGameSystem): self
    {
        if (!$this->unitGameSystems->contains($unitGameSystem)) {
            $this->unitGameSystems[] = $unitGameSystem;
            $unitGameSystem->setUnitGeneric($this);
        }

        return $this;
    }

    public function removeUnitGameSystem(UnitGameSystem $unitGameSystem): self
    {
        if ($this->unitGameSystems->removeElement($unitGameSystem)) {
            // set the owning side to null (unless already changed)
            if ($unitGameSystem->getUnitGeneric() === $this) {
                $unitGameSystem->setUnitGeneric(null);
            }
        }

        return $this;
    }
}
