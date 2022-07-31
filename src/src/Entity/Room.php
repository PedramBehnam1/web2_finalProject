<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $roomNumber = null;

    #[ORM\Column]
    private ?int $capacity = null;

    #[ORM\Column]
    private ?int $maximumCapacity = null;

    #[ORM\Column]
    private ?bool $isEmpty = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $createdUsername = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $updatedUsername = null;

    #[ORM\ManyToOne(inversedBy: 'Room')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Dorm $dorm = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $userAccounts = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoomNumber(): ?int
    {
        return $this->roomNumber;
    }

    public function setRoomNumber(int $roomNumber): self
    {
        $this->roomNumber = $roomNumber;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getmaximumCapacity(): ?int
    {
        return $this->maximumCapacity;
    }

    public function setmaximumCapacity(int $maximumCapacity): self
    {
        $this->maximumCapacity = $maximumCapacity;

        return $this;
    }

    public function isIsEmpty(): ?bool
    {
        return $this->isEmpty;
    }

    public function setIsEmpty(bool $isEmpty): self
    {
        $this->isEmpty = $isEmpty;

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

    public function getDorm(): ?Dorm
    {
        return $this->dorm;
    }

    public function setDorm(?Dorm $dorm): self
    {
        $this->dorm = $dorm;

        return $this;
    }

    public function getUserAccounts(): array
    {
        return $this->userAccounts;
    }

    public function setUserAccounts(array $userAccounts): self
    {
        $this->userAccounts = $userAccounts;

        return $this;
    }
}
