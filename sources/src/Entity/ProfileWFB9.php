<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\ORM\Mapping as ORM;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      allOf={
 *          @Model(type=Profile::class)
 *      }
 * )
 * @ORM\Entity(repositoryClass=ProfileRepository::class)
 */
class ProfileWFB9 extends Profile
{
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $movement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $weaponSkill;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ballisticSkill;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $strength;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $toughness;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $wounds;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $initiative;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $attacks;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $leadership;

    public function getProfileType(): ?string
    {
        return self::PROFILE_TYPE_WFB9;
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

    public function getWeaponSkill(): ?string
    {
        return $this->weaponSkill;
    }

    public function setWeaponSkill(?string $weaponSkill): self
    {
        $this->weaponSkill = $weaponSkill;

        return $this;
    }

    public function getBallisticSkill(): ?string
    {
        return $this->ballisticSkill;
    }

    public function setBallisticSkill(?string $ballisticSkill): self
    {
        $this->ballisticSkill = $ballisticSkill;

        return $this;
    }

    public function getStrength(): ?string
    {
        return $this->strength;
    }

    public function setStrength(?string $strength): self
    {
        $this->strength = $strength;

        return $this;
    }

    public function getToughness(): ?string
    {
        return $this->toughness;
    }

    public function setToughness(?string $toughness): self
    {
        $this->toughness = $toughness;

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

    public function getInitiative(): ?string
    {
        return $this->initiative;
    }

    public function setInitiative(?string $initiative): self
    {
        $this->initiative = $initiative;

        return $this;
    }

    public function getAttacks(): ?string
    {
        return $this->attacks;
    }

    public function setAttacks(?string $attacks): self
    {
        $this->attacks = $attacks;

        return $this;
    }

    public function getLeadership(): ?string
    {
        return $this->leadership;
    }

    public function setLeadership(?string $leadership): self
    {
        $this->leadership = $leadership;

        return $this;
    }
}
