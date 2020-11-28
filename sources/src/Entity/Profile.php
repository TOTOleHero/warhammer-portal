<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use App\Traits\TaggableTrait;
use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\InheritanceType("JOINED")
 * @ORM\Entity(repositoryClass=ProfileRepository::class)
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"profileWFB12" = "ProfileWFB12",
 *                          "profileWFB9" = "ProfileWFB9",
 *                          "profileAOS4" = "ProfileAOS4",
 *                          "profileWHQ" = "ProfileWHQ",
 *                          "profileT9A12" = "ProfileT9A12"
 * })
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "api_profile_show",
 *          parameters = { "id" = "expr(object.getId())" }
 *      )
 * )
 * @Hateoas\Relation(
 *      "unit",
 *      href = @Hateoas\Route(
 *          "api_unit_show",
 *          parameters = { "id" = "expr(object.getUnit().getId())" }
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
    protected const PROFILE_TYPE_WFB12 = 'profileWFB12';
    protected const PROFILE_TYPE_WFB9 = 'profileWFB9';
    protected const PROFILE_TYPE_AOS4 = 'profileAOS4';
    protected const PROFILE_TYPE_WHQ = 'profileWHQ';
    protected const PROFILE_TYPE_T9A12 = 'profileT9A12';

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
     * @ORM\ManyToOne(targetEntity=Unit::class, inversedBy="profiles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $unit;

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

    use TaggableTrait {
        TaggableTrait::__construct as private __taggableTraitConstruct;
    }

    public function __construct()
    {
        $this->__taggableTraitConstruct();
    }

    abstract public function getProfileType(): ?string;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getUnit(): ?Unit
    {
        return $this->unit;
    }

    public function setUnit(?Unit $unit): self
    {
        $this->unit = $unit;

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
}
