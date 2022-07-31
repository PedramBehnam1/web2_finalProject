<?php

namespace App\Entity;

use App\Repository\UniversityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UniversityRepository::class)]
class University
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $createdUsername = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $updatedUsername = null;

    #[ORM\OneToMany(mappedBy: 'university', targetEntity: Dorm::class, orphanRemoval: true)]
    private Collection $Dorm;

    public function __construct()
    {
        $this->Dorm = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCreatedUsername(): ?string
    {
        return $this->createdUsername;
    }

    public function setCreatedUsername(string $createdUsername): self
    {
        $this->createdUsername = $createdUsername;

        return $this;
    }

    public function getUpdatedUsername(): ?string
    {
        return $this->updatedUsername;
    }

    public function setUpdatedUsername(?string $updatedUsername): self
    {
        $this->updatedUsername = $updatedUsername;

        return $this;
    }

    /**
     * @return Collection<int, Dorm>
     */
    public function getDorm(): Collection
    {
        return $this->Dorm;
    }

    public function addDorm(Dorm $dorm): self
    {
        if (!$this->Dorm->contains($dorm)) {
            $this->Dorm->add($dorm);
            $dorm->setUniversity($this);
        }

        return $this;
    }

    public function removeDorm(Dorm $dorm): self
    {
        if ($this->Dorm->removeElement($dorm)) {
            // set the owning side to null (unless already changed)
            if ($dorm->getUniversity() === $this) {
                $dorm->setUniversity(null);
            }
        }

        return $this;
    }
}
