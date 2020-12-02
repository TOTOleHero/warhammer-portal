<?php

namespace App\Entity;

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
 * @Gedmo\TranslationEntity(class="App\Entity\UnitGameSystemTranslation")
 * @ORM\Entity(repositoryClass=UnitGameSystemRepository::class)
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "api_unitGameSystem_show",
 *          parameters = { "id" = "expr(object.getId())" }
 *      )
 * )
 */
class UnitGameSystem
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
    private $name;

    /**
     * @var Collection|Profile[]
     * @ORM\OneToMany(targetEntity=Profile::class, mappedBy="unitGameSystem", orphanRemoval=true)
     */
    private $profiles;

    /**
     * @ORM\ManyToMany(targetEntity=Option::class)
     */
    private $options;

  

    
    /**
     * @ORM\ManyToOne(targetEntity=UnitGeneric::class, inversedBy="unitGameSystems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $unitGeneric;

    /**
     * @ORM\ManyToOne(targetEntity=GameSystem::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $gameSystem;

    use TaggableTrait {
        TaggableTrait::__construct as private __taggableTraitConstruct;
    }

    public function __construct()
    {
        $this->__taggableTraitConstruct();

        $this->profiles = new ArrayCollection();
        $this->options = new ArrayCollection();

        $this->equipments = new ArrayCollection();
    }

    public function getAllTags()
    {
        return array_merge(
            $this->getTags()->toArray(),
        );
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getId(): ?Uuid
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

    /**
     * @return Collection|Profile[]
     */
    public function getProfiles(): Collection
    {
        return $this->profiles;
    }

    public function addProfile(Profile $profile): self
    {
        if (!$this->profiles->contains($profile)) {
            $this->profiles[] = $profile;
            $profile->setUnitGameSystem($this);
        }

        return $this;
    }

    public function removeProfile(Profile $profile): self
    {
        if ($this->profiles->removeElement($profile)) {
            // set the owning side to null (unless already changed)
            if ($profile->getUnitGameSystem() === $this) {
                $profile->setUnitGameSystem(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Option[]
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(Option $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options[] = $option;
        }

        return $this;
    }

    public function removeOption(Option $option): self
    {
        $this->options->removeElement($option);

        return $this;
    }

    
   

    public function getUnitGeneric(): ?UnitGeneric
    {
        return $this->unitGeneric;
    }

    public function setUnitGeneric(?UnitGeneric $unitGeneric): self
    {
        $this->unitGeneric = $unitGeneric;

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
}
