<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfileRepository::class)
 */
class ProfileWHQ extends Profile
{
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $battleLevel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gold;

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
    private $damageDice;

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
    private $luck;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $skills;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $escapePinning;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $willPower;

    public function getProfileType(): ?string
    {
        return self::PROFILE_TYPE_WHQ;
    }

    public function getDamageDice(): ?string
    {
        return $this->damageDice;
    }

    public function setDamageDice(?string $damageDice): self
    {
        $this->damageDice = $damageDice;

        return $this;
    }

    public function getLuck(): ?string
    {
        return $this->luck;
    }

    public function setLuck(?string $luck): self
    {
        $this->luck = $luck;

        return $this;
    }

    public function getSkills(): ?string
    {
        return $this->skills;
    }

    public function setSkills(?string $skills): self
    {
        $this->skills = $skills;

        return $this;
    }

    public function getEscapePinning(): ?string
    {
        return $this->escapePinning;
    }

    public function setEscapePinning(?string $escapePinning): self
    {
        $this->escapePinning = $escapePinning;

        return $this;
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

    public function getGold(): ?string
    {
        return $this->gold;
    }

    public function setGold(?string $gold): self
    {
        $this->gold = $gold;

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

    public function getBattleLevel(): ?string
    {
        return $this->battleLevel;
    }

    public function setBattleLevel(?string $battleLevel): self
    {
        $this->battleLevel = $battleLevel;

        return $this;
    }
}
