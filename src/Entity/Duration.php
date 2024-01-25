<?php

namespace App\Entity;

use App\Repository\DurationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DurationRepository::class)]
class Duration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $duration = null;

    #[ORM\OneToMany(mappedBy: 'duration', targetEntity: Licenses::class)]
    private Collection $licenses;

    public function __construct()
    {
        $this->licenses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return Collection<int, Licenses>
     */
    public function getLicenses(): Collection
    {
        return $this->licenses;
    }

    public function addLicense(Licenses $license): static
    {
        if (!$this->licenses->contains($license)) {
            $this->licenses->add($license);
            $license->setDuration($this);
        }

        return $this;
    }

    public function removeLicense(Licenses $license): static
    {
        if ($this->licenses->removeElement($license)) {
            // set the owning side to null (unless already changed)
            if ($license->getDuration() === $this) {
                $license->setDuration(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->duration;
    }
}
