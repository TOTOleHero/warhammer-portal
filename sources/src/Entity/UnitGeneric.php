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
 *      "nation",
 *      href = @Hateoas\Route(
 *          "api_nation_show",
 *          parameters = { "id" = "expr(object.getNation().getId())" }
 *      )
 * )
 */
class UnitGeneric
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
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=255)
     */
    private $baseName;

    /**
     * @JMS\Type("string")
     * @ORM\ManyToOne(targetEntity=Nation::class, inversedBy="units")
     * @ORM\JoinColumn(nullable=false)
     */
    private $nation;

    /**
     * @ORM\ManyToOne(targetEntity=Race::class)
     */
    private $race;

    /**
     * @ORM\OneToMany(targetEntity=UnitGameSystem::class, mappedBy="unitGeneric")
     */
    private $unitGameSystems;

    use TaggableTrait {
        TaggableTrait::__construct as private __taggableTraitConstruct;
    }

    public function __construct()
    {
        $this->__taggableTraitConstruct();
        $this->unitGameSystems = new ArrayCollection();
    }

    public function getAllTags()
    {
        return array_merge(
            $this->getTags()->toArray(),
            $this->getRace()->getAllTags(),
            $this->getNation()->getAllTags()
        );
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


    /**
     * @return UnitGameSystem
     */
    public function findUnitGamesSystemByGameSystem($gameSystem): UnitGameSystem
    {
        foreach ($this->getUnitGameSystems() as $unitGameSystem) {
            if($unitGameSystem->getGameSystem()->getId() == $gameSystem)
            {
               return $unitGameSystem;
            }
        }

        throw new GameSystemNotFoundException(sprintf('No UnitGameSystem exit with gameSystem "%s"',$gameSystem));
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

    public function getNation(): ?Nation
    {
        return $this->nation;
    }

    public function setNation(?Nation $nation): self
    {
        $this->nation = $nation;

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
