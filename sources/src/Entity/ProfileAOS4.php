<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;
use Symfony\Component\Uid\Uuid;
/**
 * @ORM\Entity(repositoryClass=ProfileRepository::class)
 */
class ProfileAOS4 extends Profile
{


    



    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $movement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $wounds;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $bravery;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $save;


    public function getProfileType(): ?string
    {
        return self::PROFILE_TYPE_AOS4;
    }

    public function getMovement(): ?string
    {
        return $this->movement;
    }

    public function setMovement(?string $movement): self
    {
        $this->movement = $movement;

        return $this;
    }

    public function getWounds(): ?string
    {
        return $this->wounds;
    }

    public function setWounds(?string $wounds): self
    {
        $this->wounds = $wounds;

        return $this;
    }

    public function getBravery(): ?string
    {
        return $this->bravery;
    }

    public function setBravery(?string $bravery): self
    {
        $this->bravery = $bravery;

        return $this;
    }

    public function getSave(): ?string
    {
        return $this->save;
    }

    public function setSave(string $save): self
    {
        $this->save = $save;

        return $this;
    }
}
