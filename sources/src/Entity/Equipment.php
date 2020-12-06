<?php

namespace App\Entity;

use App\Repository\EquipmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as JMS;
use Gedmo\Translatable\Translatable;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;
use Symfony\Component\Uid\Uuid;


/**
 * @ORM\Entity(repositoryClass=EquipmentRepository::class)
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "api_equipment_show",
 *          parameters = { "id" = "expr(object.getId())" }
 *      )
 * )
 * @Hateoas\Relation(
 *      "all",
 *      href = @Hateoas\Route(
 *          "api_equipment_index"
 *      )
 * )
 */
class Equipment implements Translatable
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
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=GameSystem::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $gameSystem;

    /**
     * @ORM\ManyToMany(targetEntity=Equipment::class)
     */
    private $relatedEquipments;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=EquipmentType::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * Post locale
     * Used locale to override Translation listener's locale.
     *
     * @Gedmo\Locale
     */
    protected $locale;    

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

    public function __construct()
    {
        $this->relatedEquipments = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->getName();
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

    public function getGameSystem(): ?GameSystem
    {
        return $this->gameSystem;
    }

    public function setGameSystem(?GameSystem $gameSystem): self
    {
        $this->gameSystem = $gameSystem;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getRelatedEquipments(): Collection
    {
        return $this->relatedEquipments;
    }

    public function addRelatedEquipment(self $relatedEquipment): self
    {
        if (!$this->relatedEquipments->contains($relatedEquipment)) {
            $this->relatedEquipments[] = $relatedEquipment;
        }

        return $this;
    }

    public function removeRelatedEquipment(self $relatedEquipment): self
    {
        $this->relatedEquipments->removeElement($relatedEquipment);

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?EquipmentType
    {
        return $this->type;
    }

    public function setType(?EquipmentType $type): self
    {
        $this->type = $type;

        return $this;
    }
}
