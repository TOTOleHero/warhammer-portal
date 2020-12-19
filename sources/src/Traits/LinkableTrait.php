<?php

namespace App\Traits;

use App\Entity\ExternalLink;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Trait class.
 */
trait LinkableTrait
{
    /**
     * @ORM\ManyToMany(targetEntity=ExternalLink::class, cascade={"persist"})
     */
    private $externalLinks;

    public function __construct()
    {
        $this->externalLinks = new ArrayCollection();
    }

    /**
     * @return Collection|ExternalLink[]
     */
    public function getExternalLinks(): Collection
    {
        return $this->externalLinks;
    }

    public function addExternalLink($externalLink): self
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
