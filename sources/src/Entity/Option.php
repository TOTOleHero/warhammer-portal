<?php

namespace App\Entity;

use App\Repository\OptionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=OptionRepository::class)
 * @ORM\Table(name="`option`")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"commandOption" = "CommandOption",
 *                          "upgradeOption" = "UpgradeOption",
 *                          "equipmentOption" = "EquipmentOption"
 *
 * })
 */
abstract class Option
{
    const OPTION_TYPE_COMMAND = 'commandOption';
    const OPTION_TYPE_UPGRADE = 'upgradeOption';
    const OPTION_TYPE_EQUIPMENT = 'equipmentOption';

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidV4Generator::class)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cost;

    /**
     * @ORM\ManyToOne(targetEntity=GameSystem::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $gameSystem;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getType(): ?OptionType
    {
        return $this->type;
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

    public function getCost(): ?string
    {
        return $this->cost;
    }

    public function setCost(string $cost): self
    {
        $this->cost = $cost;

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
