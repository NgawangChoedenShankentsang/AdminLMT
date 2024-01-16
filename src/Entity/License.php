<?php

namespace App\Entity;

use App\Repository\LicenseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LicenseRepository::class)]
class License
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $namename = null;

    #[ORM\ManyToMany(targetEntity: Website::class, mappedBy: 'licenceRelation')]
    private Collection $websites;

    public function __construct()
    {
        $this->websites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNamename(): ?string
    {
        return $this->namename;
    }

    public function setNamename(string $namename): static
    {
        $this->namename = $namename;

        return $this;
    }

    /**
     * @return Collection<int, Website>
     */
    public function getWebsites(): Collection
    {
        return $this->websites;
    }

    public function addWebsite(Website $website): static
    {
        if (!$this->websites->contains($website)) {
            $this->websites->add($website);
            $website->addLicenceRelation($this);
        }

        return $this;
    }

    public function removeWebsite(Website $website): static
    {
        if ($this->websites->removeElement($website)) {
            $website->removeLicenceRelation($this);
        }

        return $this;
    }
}
