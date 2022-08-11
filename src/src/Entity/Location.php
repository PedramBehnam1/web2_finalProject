<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location extends University
{
    
    #[ORM\Column(length: 255, nullable: true), Assert\Regex(pattern:"/^[\d]+$/")]
    #[Assert\NotBlank]
    private ?string $longitude = null;

    #[ORM\Column(length: 255, nullable: true), Assert\Regex(pattern:"/^[\d]+$/")]
    #[Assert\NotBlank]
    private ?string $Latitude = null;

    #[ORM\Column(length: 255, nullable: true), Assert\Regex(pattern:"/^[a-zA-Z0-9|\s\-]+$/")]
    #[Assert\NotBlank]
    private ?string $Address = null;


    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->Latitude;
    }

    public function setLatitude(?string $Latitude): self
    {
        $this->Latitude = $Latitude;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->Address;
    }

    public function setAddress(?string $Address): self
    {
        $this->Address = $Address;

        return $this;
    }
}
