<?php

namespace App\Entity;

use App\Interface\TimeInterface;
use App\Interface\UserInterface;
use App\Model\TimableTrait;
use App\Model\UserTrait;
use App\Repository\RoomRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room implements TimeInterface , UserInterface
{
    use TimableTrait;
    use UserTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $roomNumber = null;

    #[ORM\Column]
    private ?int $capacity = null;

    #[ORM\Column, Assert\Regex(pattern:"/^[\d]+$/")]
    private ?int $maximumCapacity = null;

    #[ORM\Column]
    private ?bool $isEmpty = null;

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
