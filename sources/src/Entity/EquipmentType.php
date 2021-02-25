<?php

namespace App\Entity;

use App\Repository\EquipmentTypeRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity(repositoryClass=EquipmentTypeRepository::class)
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "api_equipment_type_show",
 *          parameters = { "id" = "expr(object.getId())" }
 *      )
 * )
 * @Hateoas\Relation(
 *      "all",
 *      href = @Hateoas\Route(
 *          "api_equipment_type_index"
 *      )
 * )
 */
class EquipmentType implements Translatable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $id;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * Post locale
     * Used locale to override Translation listener's locale.
     *
     * @Gedmo\Locale
     */
    protected $locale;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId($id): ?EquipmentType
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
}
