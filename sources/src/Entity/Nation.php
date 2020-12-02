<?php

namespace App\Entity;

use App\Repository\NationRepository;
use App\Traits\TaggableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity(repositoryClass=NationRepository::class)
 * @Gedmo\TranslationEntity(class="App\Entity\NationTranslation")
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "api_nation_show",
 *          parameters = { "id" = "expr(object.getId())" }
 *      )
 * )
 */
class Nation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=UnitGeneric::class, mappedBy="nation")
     */
    private $unitGenerics;

    /**
     * Post locale
     * Used locale to override Translation listener's locale.
     *
     * @Gedmo\Locale
     */
    protected $locale;

    use TaggableTrait {
        TaggableTrait::__construct as private __taggableTraitConstruct;
    }

    public function __construct()
    {
        $this->__taggableTraitConstruct();
        $this->unitGenerics = new ArrayCollection();
    }

    public function getAllTags()
    {
        return array_merge(
            $this->getTags()->toArray(),
        );
    }

    /**
     * Sets translatable locale.
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
        return $this->getId().' - '.$this->getName();
    }

    public function getId(): ?string
    {
        return $this->id;
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

    /**
     * @return Collection|UnitGeneric[]
     */
    public function getUnitGenerics(): Collection
    {
        return $this->unitGenerics;
    }

    public function addUnitGeneric(UnitGeneric $unitGeneric): self
    {
        if (!$this->unitGenerics->contains($unitGeneric)) {
            $this->unitGenerics[] = $unitGeneric;
            $unitGeneric->setNation($this);
        }

        return $this;
    }

    public function removeUnitGeneric(UnitGeneric $unitGeneric): self
    {
        if ($this->unitGenerics->removeElement($unitGeneric)) {
            // set the owning side to null (unless already changed)
            if ($unitGeneric->getNation() === $this) {
                $unitGeneric->setNation(null);
            }
        }

        return $this;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }
}
