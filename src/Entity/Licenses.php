<?php

namespace App\Entity;

use App\Repository\LicensesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LicensesRepository::class)]
class Licenses
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $licenseKey = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $notes = null;

    #[ORM\ManyToOne(inversedBy: 'licenses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?products $productId = null;

    #[ORM\ManyToMany(targetEntity: Websites::class, inversedBy: 'licenseId')]
    private Collection $websites;

    #[ORM\ManyToOne(inversedBy: 'licenses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $createdBy = null;

    #[ORM\ManyToOne(inversedBy: 'licenses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Duration $duration = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $url = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $price = null;

    #[ORM\ManyToOne(inversedBy: 'licenses')]
    private ?Paid $paidBy = null;

    public function __construct()
    {
        $this->websites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLicenseKey(): ?string
    {
        return $this->licenseKey;
    }

    public function setLicenseKey(?string $licenseKey): static
    {
        $this->licenseKey = $licenseKey;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

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
    
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): static
    {
        $this->notes = $notes;

        return $this;
    }

    public function getProductId(): ?products
    {
        return $this->productId;
    }

    public function setProductId(?products $productId): static
    {
        $this->productId = $productId;

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
            $website->addLicenseId($this);
        }

        return $this;
    }

    public function removeWebsite(Websites $website): static
    {
        if ($this->websites->removeElement($website)) {
            $website->removeLicenseId($this);
        }

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
    public function __toString()
    {
        return $this->licenseKey ?? 'None';
    }

    public function getDuration(): ?Duration
    {
        return $this->duration;
    }

    public function setDuration(?Duration $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getPaidBy(): ?Paid
    {
        return $this->paidBy;
    }

    public function setPaidBy(?Paid $paidBy): static
    {
        $this->paidBy = $paidBy;

        return $this;
    }
}
