<?php

namespace App\Entity;

use App\Repository\WebsiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WebsiteRepository::class)]
class Website
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $Active = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Start_Date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $end_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $license_key = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comments = null;

    #[ORM\ManyToMany(targetEntity: License::class, inversedBy: 'websites')]
    private Collection $licenceRelation;

    public function __construct()
    {
        $this->licenceRelation = new ArrayCollection();
        $this->updated_at = new \DateTimeImmutable(); // Set a default value

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

    public function isActive(): ?bool
    {
        return $this->Active;
    }

    public function setActive(bool $Active): static
    {
        $this->Active = $Active;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->Start_Date;
    }

    public function setStartDate(\DateTimeInterface $Start_Date): static
    {
        $this->Start_Date = $Start_Date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): static
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getLicenseKey(): ?string
    {
        return $this->license_key;
    }

    public function setLicenseKey(?string $license_key): static
    {
        $this->license_key = $license_key;

        return $this;
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(?string $comments): static
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * @return Collection<int, License>
     */
    public function getLicenceRelation(): Collection
    {
        return $this->licenceRelation;
    }

    public function addLicenceRelation(License $licenceRelation): static
    {
        if (!$this->licenceRelation->contains($licenceRelation)) {
            $this->licenceRelation->add($licenceRelation);
        }

        return $this;
    }

    public function removeLicenceRelation(License $licenceRelation): static
    {
        $this->licenceRelation->removeElement($licenceRelation);

        return $this;
    }
}
