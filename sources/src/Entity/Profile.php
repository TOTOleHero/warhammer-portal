<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use App\Traits\TaggableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=ProfileRepository::class)
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"profileWFB12" = "ProfileWFB12",
 *                          "profileWFB9" = "ProfileWFB9",
 *                          "profileAOS4" = "ProfileAOS4",
 *                          "profileWHQ" = "ProfileWHQ",
 *                          "profileT9A12" = "ProfileT9A12",
 *                          "profileKOW" = "ProfileKOW",
 *                          "profileUnknown" = "ProfileUnknown"
 * })
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "api_profile_show",
 *          parameters = { "id" = "expr(object.getId())" }
 *      )
 * )
 * @Hateoas\Relation(
 *      "unitGameSystem",
 *      href = @Hateoas\Route(
 *          "api_unitGameSystem_show",
 *          parameters = { "id" = "expr(object.getUnitGameSystem().getId())" }
 *      )
 * )
 * @Hateoas\Relation(
 *      "gameSystem",
 *      href = @Hateoas\Route(
 *          "api_game_system_show",
 *          parameters = { "id" = "expr(object.getGameSystem().getId())" }
 *      )
 * )
 */
abstract class Profile
{
    use TaggableTrait {
        TaggableTrait::__construct as private __taggableTraitConstruct;
    }
    
    
    /*
        don't forget to change @ORM\DiscriminatorMap below
    */
    protected const PROFILE_TYPE_WFB12 = 'profileWFB12';
    protected const PROFILE_TYPE_WFB9 = 'profileWFB9';
    protected const PROFILE_TYPE_AOS4 = 'profileAOS4';
    protected const PROFILE_TYPE_WHQ = 'profileWHQ';
    protected const PROFILE_TYPE_T9A12 = 'profileT9A12';
    protected const PROFILE_TYPE_KOW = 'profileKOW';
    protected const PROFILE_TYPE_UNKNOWN = 'profileUnknown';

    /**
     * @ORM\Id
     * @JMS\Type("string")
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidV4Generator::class)
     */
    private $id;

    /**
     * @JMS\Type("string")
     * @ORM\ManyToOne(targetEntity=UnitGameSystem::class, inversedBy="profiles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $unitGameSystem;

    /**
     * @ORM\ManyToOne(targetEntity=GameSystem::class)
     * @ORM\JoinColumn(nullable=false)
     * @JMS\Type("string")
     */
    private $gameSystem;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Equipment::class)
     */
    private $equipments;

    /**
     * @ORM\ManyToMany(targetEntity=Rule::class)
     */
    private $rules;

    public function __construct()
    {
        $this->__taggableTraitConstruct();
        $this->equipments = new ArrayCollection();
        $this->rules = new ArrayCollection();
    }

    abstract public function getProfileType(): ?string;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getUnitGameSystem(): ?UnitGameSystem
    {
        return $this->unitGameSystem;
    }

    public function setUnitGameSystem(?UnitGameSystem $unitGameSystem): self
    {
        $this->unitGameSystem = $unitGameSystem;

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
     * @return Collection|Equipment[]
     */
    public function getEquipments(): Collection
    {
        return $this->equipments;
    }

    public function addEquipment(Equipment $equipment): self
    {
        if (!$this->equipments->contains($equipment)) {
            $this->equipments[] = $equipment;
        }

        return $this;
    }

    public function removeEquipment(Equipment $equipment): self
    {
        $this->equipments->removeElement($equipment);

        return $this;
    }

    /**
     * @return Collection|Rule[]
     */
    public function getRules(): Collection
    {
        return $this->rules;
    }

    public function addRule(Rule $rule): self
    {
        if (!$this->rules->contains($rule)) {
            $this->rules[] = $rule;
        }

        return $this;
    }

    public function removeRule(Rule $rule): self
    {
        $this->rules->removeElement($rule);

        return $this;
    }
}
