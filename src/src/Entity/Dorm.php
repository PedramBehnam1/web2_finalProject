<?php

namespace App\Entity;

use App\Interface\TimeInterface;
use App\Interface\UserInterface;
use App\Model\TimableTrait;
use App\Model\UserTrait;
use App\Repository\DormRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: DormRepository::class)]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
class Dorm implements TimeInterface , UserInterface
{
    use TimableTrait;
    use UserTrait;
    use SoftDeleteableEntity; 

    const ROLE_EDITOR = "ROLE_EDITOR";
    const ROLE_DORM_OWNER = "ROLE_DORM_OWNER";


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255), Assert\Regex(pattern:"/^[a-zA-Z|\s]+$/")]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column, Assert\Range([
        'min' => 1,
        'max' => 10,
        'notInRangeMessage' => 'You must be between {{ min }} and {{ max }} .',
    ])]
    private ?int $score = null;


    #[ORM\ManyToOne(inversedBy: 'Dorm')]
    #[ORM\JoinColumn(nullable: false)]
    private ?University $university = null;

    #[ORM\OneToMany(mappedBy: 'dorm', targetEntity: Room::class, orphanRemoval: true)]
    private Collection $Room;

    #[ORM\ManyToOne(inversedBy: 'dorms')]
    private ?User $owner = null;

    #[ORM\ManyToOne(inversedBy: 'dormsEditor')]
    private ?User $editor = null;

    public function __construct()
    {
        $this->Room = new ArrayCollection();
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

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getUniversity(): ?University
    {
        return $this->university;
    }

    public function setUniversity(?University $university): self
    {
        $this->university = $university;

        return $this;
    }

    /**
     * @return Collection<int, Room>
     */
    public function getRoom(): Collection
    {
        return $this->Room;
    }

    public function addRoom(Room $room): self
    {
        if (!$this->Room->contains($room)) {
            $this->Room->add($room);
            $room->setDorm($this);
        }

        return $this;
    }

    public function removeRoom(Room $room): self
    {
        if ($this->Room->removeElement($room)) {
            // set the owning side to null (unless already changed)
            if ($room->getDorm() === $this) {
                $room->setDorm(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getEditor(): ?User
    {
        return $this->editor;
    }

    public function setEditor(?User $editor): self
    {
        $this->editor = $editor;

        return $this;
    }
}
