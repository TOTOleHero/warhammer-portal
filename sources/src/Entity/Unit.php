<?php

namespace App\Entity;

use App\Repository\UnitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;
use Symfony\Component\Uid\Uuid;
use JMS\Serializer\Annotation as JMS;
use Hateoas\Configuration\Annotation as Hateoas;

use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/**
 * @Gedmo\TranslationEntity(class="App\Entity\UnitTranslation")
 * @ORM\Entity(repositoryClass=UnitRepository::class)
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "api_unit_show",
 *          parameters = { "id" = "expr(object.getId())" }
 *      )
 * )
  * @Hateoas\Relation(
 *      "nation",
 *      href = @Hateoas\Route(
 *          "api_nation_show",
 *          parameters = { "id" = "expr(object.getNation().getId())" }
 *      )
 * )
 */
class Unit
{
    /**
     * @ORM\Id
     * @JMS\Type("string")
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidV4Generator::class)

     */
    private $id;

    /**
     * @Gedmo\Translatable 
     * @ORM\Column(type="string", length=255)
     */
    private $baseName;

    /**
     * @JMS\Type("string")
     * @ORM\ManyToOne(targetEntity=Nation::class, inversedBy="units")
     * @ORM\JoinColumn(nullable=false)
     */
    private $nation;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class)
     */
    private $tags;

    /**
     * @var Collection|Profile[]
     * @ORM\OneToMany(targetEntity=Profile::class, mappedBy="unit", orphanRemoval=true)
     */
    private $profiles;

    /**
     * @ORM\ManyToMany(targetEntity=Option::class)
     */
    private $options;

    /**
     * @ORM\ManyToOne(targetEntity=Race::class)
     */
    private $race;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->profiles = new ArrayCollection();
        $this->options = new ArrayCollection();
    }


    /**
     * @return Collection|GameSystem[]
     */
    public function getGameSystems(): array
    {
        $gameSystems = [];
        foreach($this->profiles as $profile)
        {
           
            $gameSystemId = $profile->getGameSystem()->getId();
           
            if( ! array_key_exists($gameSystemId,$gameSystems))
            {
                $gameSystems[$gameSystemId]=[];
            }
            $gameSystems[$gameSystemId]=$profile->getGameSystem();
            ksort($gameSystems);
        }
     
        return $gameSystems;
        
    }

    /**
     * @return Collection|Profile[]
     */
    public function getProfilesByGameSystems(): array
    {
        //flat gamesystem array
        $profilesByGameSystems = array_map(function($value) { return []; },$this->getGameSystems());
       
        foreach($this->profiles as $profile)
        {
            $profilesByGameSystems[$profile->getGameSystem()->getId()][]=$profile;
        }
     
        return $profilesByGameSystems;
        
    }



    public function __toString()
    {
        return $this->getBaseName();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getBaseName(): ?string
    {
        return $this->baseName;
    }

    public function setBaseName(string $baseName): self
    {
        $this->baseName = $baseName;

        return $this;
    }

    public function getNation(): ?Nation
    {
        return $this->nation;
    }

    public function setNation(?Nation $nation): self
    {
        $this->nation = $nation;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    /**
     * @return Collection|Profile[]
     */
    public function getProfiles(): Collection
    {
        return $this->profiles;
    }

    public function addProfile(Profile $profile): self
    {
        if (!$this->profiles->contains($profile)) {
            $this->profiles[] = $profile;
            $profile->setUnit($this);
        }

        return $this;
    }

    public function removeProfile(Profile $profile): self
    {
        if ($this->profiles->removeElement($profile)) {
            // set the owning side to null (unless already changed)
            if ($profile->getUnit() === $this) {
                $profile->setUnit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Option[]
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(Option $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options[] = $option;
        }

        return $this;
    }

    public function removeOption(Option $option): self
    {
        $this->options->removeElement($option);

        return $this;
    }

    public function getRace(): ?Race
    {
        return $this->race;
    }

    public function setRace(?Race $race): self
    {
        $this->race = $race;

        return $this;
    }
}
