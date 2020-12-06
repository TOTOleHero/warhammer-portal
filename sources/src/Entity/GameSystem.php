<?php

namespace App\Entity;

use App\Repository\GameSystemRepository;
use App\Traits\TaggableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @Gedmo\TranslationEntity(class="App\Entity\GameSystemTranslation")
 * @ORM\Entity(repositoryClass=GameSystemRepository::class)
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "api_game_system_show",
 *          parameters = { "id" = "expr(object.getId())" }
 *      )
 * )
 * @Hateoas\Relation(
 *      "all",
 *      href = @Hateoas\Route(
 *          "api_game_system_index"
 *      )
 * )
 */
class GameSystem implements Translatable
{
    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $publisher;

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
     * @ORM\ManyToOne(targetEntity=ProfileType::class, inversedBy="gameSystems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $profileType;

    /**
     * @ORM\ManyToOne(targetEntity=World::class, inversedBy="gameSystems")
     */
    private $world;

    /**
     * @ORM\ManyToMany(targetEntity=ExternalLink::class)
     */
    private $externalLinks;

    use TaggableTrait {
        TaggableTrait::__construct as private __taggableTraitConstruct;
    }

    public function __construct()
    {
        $this->__taggableTraitConstruct();
        $this->externalLinks = new ArrayCollection();
    }

    public function getAllTags()
    {
        return array_merge(
            $this->getTags()->toArray(),
        );
    }

    public function __toString()
    {
        return $this->getId().' - '.$this->getName();
    }

    public function newProfile()
    {
        $profileClassName = $this->getProfileType()->getProfileClassName();

        return (new $profileClassName())
            ->setGameSystem($this);
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

    public function getProfileType(): ?ProfileType
    {
        return $this->profileType;
    }

    public function setProfileType(?ProfileType $profileType): self
    {
        $this->profileType = $profileType;

        return $this;
    }

    public function getWorld(): ?World
    {
        return $this->world;
    }

    public function setWorld(?World $world): self
    {
        $this->world = $world;

        return $this;
    }

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    public function setPublisher(string $publisher): self
    {
        $this->publisher = $publisher;

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
