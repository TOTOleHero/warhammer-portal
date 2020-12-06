<?php

namespace App\Entity;

use App\Repository\RaceRepository;
use App\Traits\TaggableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Hateoas\Configuration\Annotation as Hateoas;

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
 *      "all",
 *      href = @Hateoas\Route(
 *          "api_race_index"
 *      )
 * )
 */
class Race
{
    /**
     * @Gedmo\Translatable
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
     * Used locale to override Translation listener's locale.
     *
     * @Gedmo\Locale
     */
    protected $locale;

    /**
     * @ORM\ManyToMany(targetEntity=ExternalLink::class)
     */
    private $externalLinks;

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

    use TaggableTrait {
        TaggableTrait::__construct as private __taggableTraitConstruct;
    }

    public function __construct()
    {
        $this->__taggableTraitConstruct();
        $this->units = new ArrayCollection();
        $this->nations = new ArrayCollection();
        $this->externalLinks = new ArrayCollection();
    }

    public function getAllTags()
    {
        return array_merge(
            $this->getTags()->toArray(),
        );
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
     * @return Collection|ExternalLink[]
     */
    public function getExternalLinks(): Collection
    {
        return $this->externalLinks;
    }

    public function addExternalLink(ExternalLink $externalLink): self
    {
        if (!$this->externalLinks->contains($externalLink)) {
            $this->externalLinks[] = $externalLink;
        }

        return $this;
    }

    public function removeExternalLink(ExternalLink $externalLink): self
    {
        $this->externalLinks->removeElement($externalLink);

        return $this;
    }
}
