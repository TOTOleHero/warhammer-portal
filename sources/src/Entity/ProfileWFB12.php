<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\ORM\Mapping as ORM;

use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;

/**
  * @SWG\Definition(
 *      allOf={
 *          @SWG\Schema(ref=@Model(type=Profile::class))
 *      }
 * )
 * @ORM\Entity(repositoryClass=ProfileRepository::class)
 */
class ProfileWFB12 extends Profile
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

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $intelligence;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cool;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $willPower;

    public function getProfileType(): ?string
    {
        return self::PROFILE_TYPE_WFB12;
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

    public function getIntelligence(): ?string
    {
        return $this->intelligence;
    }

    public function setIntelligence(?string $intelligence): self
    {
        $this->intelligence = $intelligence;

        return $this;
    }

    public function getCool(): ?string
    {
        return $this->cool;
    }

    public function setCool(?string $cool): self
    {
        $this->cool = $cool;

        return $this;
    }

    public function getWillPower(): ?string
    {
        return $this->willPower;
    }

    public function setWillPower(?string $willPower): self
    {
        $this->willPower = $willPower;

        return $this;
    }
}
