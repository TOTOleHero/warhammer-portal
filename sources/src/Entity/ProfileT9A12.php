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
class ProfileT9A12 extends Profile
{
    /**
     * @ORM\Column(type="string", length=255)
     * The distance the model can Advance Move in inches.
     */
    private $globalAdvanceRate;

    /**
     * @ORM\Column(type="string", length=255)
     * Rate The distance the model can March Move in inches.
     */
    private $globalMarch;

    /**
     * @ORM\Column(type="string", length=255)
     * The model’s ability to stand and fight.
     */
    private $globalDiscipline;

    /**
     * @ORM\Column(type="string", length=255)
     * When the model loses this many Health Points, it is removed as a casualty.
     */
    private $defensiveHealthPoints;

    /**
     * @ORM\Column(type="string", length=255)
     * How well the model avoids being hit in melee.
     */
    private $defensiveSkill;

    /**
     * @ORM\Column(type="string", length=255)
     * How easily the model withstands blows.
     */
    private $defensiveResilience;

    /**
     * @ORM\Column(type="string", length=255)
     * The innate Armour of the model.
     */
    private $defensiveArmour;

    /**
     * @ORM\Column(type="string", length=255)
     * Model parts with a higher Agility strike first in melee.
     */
    private $offensiveAgility;

    /**
     * @ORM\Column(type="string", length=255)
     * Value The number of times the model part can strike in a Round of Combat.
     */
    private $offensiveAttack;

    /**
     * @ORM\Column(type="string", length=255)
     *  How good the model part is at scoring hits in melee.
     */
    private $offensiveSkill;

    /**
     * @ORM\Column(type="string", length=255)
     *  How easily the model can wound enemy models.
     */
    private $offensiveStrength;

    /**
     * @ORM\Column(type="string", length=255)
     * How well the model can penetrate the Armour of enemy models
     */
    private $offensiveArmourPenetration;

    public function getProfileType(): ?string
    {
        return self::PROFILE_TYPE_T9A12;
    }

    public function getGlobalAdvanceRate(): ?string
    {
        return $this->globalAdvanceRate;
    }

    public function setGlobalAdvanceRate(string $globalAdvanceRate): self
    {
        $this->globalAdvanceRate = $globalAdvanceRate;

        return $this;
    }

    public function getGlobalMarch(): ?string
    {
        return $this->globalMarch;
    }

    public function setGlobalMarch(string $globalMarch): self
    {
        $this->globalMarch = $globalMarch;

        return $this;
    }

    public function getGlobalDiscipline(): ?string
    {
        return $this->globalDiscipline;
    }

    public function setGlobalDiscipline(string $globalDiscipline): self
    {
        $this->globalDiscipline = $globalDiscipline;

        return $this;
    }

    public function getDefensiveHealthPoints(): ?string
    {
        return $this->defensiveHealthPoints;
    }

    public function setDefensiveHealthPoints(string $defensiveHealthPoints): self
    {
        $this->defensiveHealthPoints = $defensiveHealthPoints;

        return $this;
    }

    public function getDefensiveSkill(): ?string
    {
        return $this->defensiveSkill;
    }

    public function setDefensiveSkill(string $defensiveSkill): self
    {
        $this->defensiveSkill = $defensiveSkill;

        return $this;
    }

    public function getDefensiveResilience(): ?string
    {
        return $this->defensiveResilience;
    }

    public function setDefensiveResilience(string $defensiveResilience): self
    {
        $this->defensiveResilience = $defensiveResilience;

        return $this;
    }

    public function getDefensiveArmour(): ?string
    {
        return $this->defensiveArmour;
    }

    public function setDefensiveArmour(string $defensiveArmour): self
    {
        $this->defensiveArmour = $defensiveArmour;

        return $this;
    }

    public function getOffensiveAgility(): ?string
    {
        return $this->offensiveAgility;
    }

    public function setOffensiveAgility(string $offensiveAgility): self
    {
        $this->offensiveAgility = $offensiveAgility;

        return $this;
    }

    public function getOffensiveAttack(): ?string
    {
        return $this->offensiveAttack;
    }

    public function setOffensiveAttack(string $offensiveAttack): self
    {
        $this->offensiveAttack = $offensiveAttack;

        return $this;
    }

    public function getOffensiveSkill(): ?string
    {
        return $this->offensiveSkill;
    }

    public function setOffensiveSkill(string $offensiveSkill): self
    {
        $this->offensiveSkill = $offensiveSkill;

        return $this;
    }

    public function getOffensiveStrength(): ?string
    {
        return $this->offensiveStrength;
    }

    public function setOffensiveStrength(string $offensiveStrength): self
    {
        $this->offensiveStrength = $offensiveStrength;

        return $this;
    }

    public function getOffensiveArmourPenetration(): ?string
    {
        return $this->offensiveArmourPenetration;
    }

    public function setOffensiveArmourPenetration(string $offensiveArmourPenetration): self
    {
        $this->offensiveArmourPenetration = $offensiveArmourPenetration;

        return $this;
    }
}
