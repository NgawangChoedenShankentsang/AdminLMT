<?php

namespace App\Entity;

use App\Repository\PaidRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaidRepository::class)]
class Paid
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'paidBy', targetEntity: Licenses::class)]
    private Collection $licenses;

    public function __construct()
    {
        $this->licenses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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
            $license->setPaidBy($this);
        }

        return $this;
    }

    public function removeLicense(Licenses $license): static
    {
        if ($this->licenses->removeElement($license)) {
            // set the owning side to null (unless already changed)
            if ($license->getPaidBy() === $this) {
                $license->setPaidBy(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->name;
    }
}
