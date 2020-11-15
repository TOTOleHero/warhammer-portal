<?php

namespace App\Entity;

use App\Repository\GameSystemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Hateoas\Configuration\Annotation as Hateoas;

use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

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
 */
class GameSystem implements Translatable
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
     * Used locale to override Translation listener's locale
     *
     * @Gedmo\Locale
     */
    protected $locale;

    /**
     * @ORM\ManyToOne(targetEntity=ProfileType::class, inversedBy="gameSystems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $profileType;



    public function __construct()
    {
    }

    public function __toString()
    {
        return $this->getId() . ' - ' . $this->getName();
    }


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
}
