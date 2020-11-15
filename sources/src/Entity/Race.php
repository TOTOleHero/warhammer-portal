<?php

namespace App\Entity;

use App\Repository\RaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;

use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/**
 * @ORM\Entity(repositoryClass=RaceRepository::class)
 * @Gedmo\TranslationEntity(class="App\Entity\RaceTranslation")
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "api_race_show",
 *          parameters = { "id" = "expr(object.getId())" }
 *      )
 * )
* @Hateoas\Relation(
 *      "allRace",
 *      href = @Hateoas\Route(
 *          "api_race_index"
 *      )
 * )
 */
class Race
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

 
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $id;


    /**
     * Post locale
     * Used locale to override Translation listener's locale
     *
     * @Gedmo\Locale
     */
    protected $locale;

    /**
     * @ORM\OneToMany(targetEntity=Nation::class, mappedBy="race")
     */
    private $nations;

    /**
     * Sets translatable locale
     *
     * @param string $locale
     */
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }


    public function __toString()
    {
        return $this->getId() . ' - '.$this->getName();
    }

    public function __construct()
    {
        $this->units = new ArrayCollection();
        $this->nations = new ArrayCollection();
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



    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Collection|Nation[]
     */
    public function getNations(): Collection
    {
        return $this->nations;
    }

    public function addNation(Nation $nation): self
    {
        if (!$this->nations->contains($nation)) {
            $this->nations[] = $nation;
            $nation->setRace($this);
        }

        return $this;
    }

    public function removeNation(Nation $nation): self
    {
        if ($this->nations->removeElement($nation)) {
            // set the owning side to null (unless already changed)
            if ($nation->getRace() === $this) {
                $nation->setRace(null);
            }
        }

        return $this;
    }
}
