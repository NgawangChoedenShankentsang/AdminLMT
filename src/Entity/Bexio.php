<?php

namespace App\Entity;

use App\Repository\BexioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BexioRepository::class)]
class Bexio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $accountName = null;

    #[ORM\Column]
    private ?string $accountId = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\OneToMany(mappedBy: 'bexio', targetEntity: Websites::class)]
    private Collection $websites;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'bexios')]
    private ?user $createdBy = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $notes = null;

    public function __construct()
    {
        $this->websites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccountName(): ?string
    {
        return $this->accountName;
    }

    public function setAccountName(string $accountName): static
    {
        $this->accountName = $accountName;

        return $this;
    }

    public function getAccountId(): ?string
    {
        return $this->accountId;
    }

    public function setAccountId(string $accountId): static
    {
        $this->accountId = $accountId;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Collection<int, Websites>
     */
    public function getWebsites(): Collection
    {
        return $this->websites;
    }

    public function addWebsite(Websites $website): static
    {
        if (!$this->websites->contains($website)) {
            $this->websites->add($website);
            $website->setBexio($this);
        }

        return $this;
    }

    public function removeWebsite(Websites $website): static
    {
        if ($this->websites->removeElement($website)) {
            // set the owning side to null (unless already changed)
            if ($website->getBexio() === $this) {
                $website->setBexio(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCreatedBy(): ?user
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?user $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): static
    {
        $this->notes = $notes;

        return $this;
    }
    public function __toString()
    {
        return $this->accountId;
    }
}
