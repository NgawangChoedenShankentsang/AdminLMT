<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Products::class)]
    private Collection $products;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Licenses::class)]
    private Collection $licenses;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Websites::class)]
    private Collection $websites;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Bexio::class)]
    private Collection $bexios;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->licenses = new ArrayCollection();
        $this->websites = new ArrayCollection();
        $this->bexios = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Products>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Products $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setCreatedBy($this);
        }

        return $this;
    }

    public function removeProduct(Products $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCreatedBy() === $this) {
                $product->setCreatedBy(null);
            }
        }

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
            $license->setCreatedBy($this);
        }

        return $this;
    }

    public function removeLicense(Licenses $license): static
    {
        if ($this->licenses->removeElement($license)) {
            // set the owning side to null (unless already changed)
            if ($license->getCreatedBy() === $this) {
                $license->setCreatedBy(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->email;
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
            $website->setCreatedBy($this);
        }

        return $this;
    }

    public function removeWebsite(Websites $website): static
    {
        if ($this->websites->removeElement($website)) {
            // set the owning side to null (unless already changed)
            if ($website->getCreatedBy() === $this) {
                $website->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Bexio>
     */
    public function getBexios(): Collection
    {
        return $this->bexios;
    }

    public function addBexio(Bexio $bexio): static
    {
        if (!$this->bexios->contains($bexio)) {
            $this->bexios->add($bexio);
            $bexio->setCreatedBy($this);
        }

        return $this;
    }

    public function removeBexio(Bexio $bexio): static
    {
        if ($this->bexios->removeElement($bexio)) {
            // set the owning side to null (unless already changed)
            if ($bexio->getCreatedBy() === $this) {
                $bexio->setCreatedBy(null);
            }
        }

        return $this;
    }
}
