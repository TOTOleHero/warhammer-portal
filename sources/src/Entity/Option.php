<?php

namespace App\Entity;

use App\Repository\OptionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;
use Symfony\Component\Uid\Uuid;
/**
 * @ORM\Entity(repositoryClass=OptionRepository::class)
 * @ORM\Table(name="`option`")
 */
class Option
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidV4Generator::class)
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=OptionType::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getType(): ?OptionType
    {
        return $this->type;
    }

    public function setType(?OptionType $type): self
    {
        $this->type = $type;

        return $this;
    }
}
