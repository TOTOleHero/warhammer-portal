<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\ORM\Mapping as ORM;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      allOf={
 *         @Model(type=Profile::class)
 *      }
 * )
 * @ORM\Entity(repositoryClass=ProfileRepository::class)
 */
class ProfileKOW extends Profile
{
    /**
     *    Whether the unit is Infantry, Cavalry, etc.
     *
     *    @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $unitType;
    /**
     *   How many models the unit comprises.
     *
     *   @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $unitSize;
    /**
     *   (Sp). How fast the unit moves, in inches.
     *
     *   @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $speed;
    /**
     *  (Me). The score needed by the unit to hit in melee.
     *
     *  @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $melee;
    /**
     *  (Ra). The score needed by the unit to hit with
     *  ranged attacks. If it has no normal ranged attacks, this is
     *  a ‘–’.
     *
     *  @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $ranged;
    /**
     *  (De). The score the enemy requires to damage the
     *  unit.
     *
     *  @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $defence;
    /**
     *  (Ht). The unit’s Height value. This value is used
     *  primarily when determining Line of Sight.
     *
     *  @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $height;
    /**
     *   (US). Unit Strength represents the
     *  presence a unit exerts on its surroundings and its ability
     *  to control the battlefield. It’s frequently used when scoring
     *   scenarios to determine the winner of a game.
     *
     *   @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $unitStrength;
    /**
     *   (Att). The number of dice the unit rolls when
     *   attacking, both at range and in melee.
     *
     *   @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $attacks;
    /**
     *   (Ne). A combination of the unit’s size and its
     *   training and discipline. This stat shows how resistant it is
     *   to damage suffered – both physical damage to its warriors,
     *   but also to its morale.
     *
     *   @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $nerve;
    /**
     *   (Pts). How valuable the unit is. Used for picking
     *  a force and sometimes for working out victory points in
     *  scenarios to determine the winner of a game.
     *
     *   @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $points;
    /**
     *  Any special equipment (like ranged weapons) and
     *  rules the unit has.
     *
     *  @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $pecial;

    public function getProfileType(): ?string
    {
        return self::PROFILE_TYPE_KOW;
    }

    
    /**
     * Get how many models the unit comprises.
     */
    public function getUnitSize()
    {
        return $this->unitSize;
    }

    /**
     * Set how many models the unit comprises.
     *
     * @return self
     */
    public function setUnitSize($unitSize)
    {
        $this->unitSize = $unitSize;

        return $this;
    }

    /**
     * Get (Sp). How fast the unit moves, in inches.
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * Set (Sp). How fast the unit moves, in inches.
     *
     * @return self
     */
    public function setSpeed($speed)
    {
        $this->speed = $speed;

        return $this;
    }

    /**
     * Get (Me). The score needed by the unit to hit in melee.
     */
    public function getMelee()
    {
        return $this->melee;
    }

    /**
     * Set (Me). The score needed by the unit to hit in melee.
     *
     * @return self
     */
    public function setMelee($melee)
    {
        $this->melee = $melee;

        return $this;
    }

    /**
     * Get (Ra). The score needed by the unit to hit with.
     */
    public function getRanged()
    {
        return $this->ranged;
    }

    /**
     * Set (Ra). The score needed by the unit to hit with.
     *
     * @return self
     */
    public function setRanged($ranged)
    {
        $this->ranged = $ranged;

        return $this;
    }

    /**
     * Get (De). The score the enemy requires to damage the.
     */
    public function getDefence()
    {
        return $this->defence;
    }

    /**
     * Set (De). The score the enemy requires to damage the.
     *
     * @return self
     */
    public function setDefence($defence)
    {
        $this->defence = $defence;

        return $this;
    }

    /**
     * Get (Ht). The unit’s Height value. This value is used.
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set (Ht). The unit’s Height value. This value is used.
     *
     * @return self
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get (US). Unit Strength represents the.
     */
    public function getUnitStrength()
    {
        return $this->unitStrength;
    }

    /**
     * Set (US). Unit Strength represents the.
     *
     * @return self
     */
    public function setUnitStrength($unitStrength)
    {
        $this->unitStrength = $unitStrength;

        return $this;
    }

    /**
     * Get (Att). The number of dice the unit rolls when.
     */
    public function getAttacks()
    {
        return $this->attacks;
    }

    /**
     * Set (Att). The number of dice the unit rolls when.
     *
     * @return self
     */
    public function setAttacks($attacks)
    {
        $this->attacks = $attacks;

        return $this;
    }

    /**
     * Get (Ne). A combination of the unit’s size and its.
     */
    public function getNerve()
    {
        return $this->nerve;
    }

    /**
     * Set (Ne). A combination of the unit’s size and its.
     *
     * @return self
     */
    public function setNerve($nerve)
    {
        $this->nerve = $nerve;

        return $this;
    }

    /**
     * Get (Pts). How valuable the unit is. Used for picking.
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set (Pts). How valuable the unit is. Used for picking.
     *
     * @return self
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get any special equipment (like ranged weapons) and.
     */
    public function getPecial()
    {
        return $this->pecial;
    }

    /**
     * Set any special equipment (like ranged weapons) and.
     *
     * @return self
     */
    public function setPecial($pecial)
    {
        $this->pecial = $pecial;

        return $this;
    }

    /**
     * Get whether the unit is Infantry, Cavalry, etc.
     */ 
    public function getUnitType()
    {
        return $this->unitType;
    }

    /**
     * Set whether the unit is Infantry, Cavalry, etc.
     *
     * @return  self
     */ 
    public function setUnitType($unitType)
    {
        $this->unitType = $unitType;

        return $this;
    }
}
