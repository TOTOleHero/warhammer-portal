<?php

namespace App\Entity;

use App\Repository\AligmentRepository;
use App\Traits\TaggableTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/**
 * @Gedmo\TranslationEntity(class="App\Entity\AlignmentTranslation")
 * @ORM\Entity(repositoryClass=AligmentRepository::class)
 */
class Alignment
{
    use TaggableTrait {
        TaggableTrait::__construct as private __taggableTraitConstruct;
    }
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
     * @ORM\Column(type="string", length=5000, nullable=true)
     */
    private $description;

    /**
     * Post locale
     * Used locale to override Translation listener's locale.
     *
     * @Gedmo\Locale
     */
    protected $locale;

    public function __construct()
    {
        $this->__taggableTraitConstruct();
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

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
