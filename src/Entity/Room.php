<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $roomName = null;

    #[ORM\Column(length: 255)]
    private ?string $roomDesc = null;

    #[ORM\Column(nullable: true)]
    private ?array $roomItems = null;

    #[ORM\Column]
    private array $roomDirection = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoomName(): ?string
    {
        return $this->roomName;
    }

    public function setRoomName(string $roomName): static
    {
        $this->roomName = $roomName;

        return $this;
    }

    public function getRoomDesc(): ?string
    {
        return $this->roomDesc;
    }

    public function setRoomDesc(string $roomDesc): static
    {
        $this->roomDesc = $roomDesc;

        return $this;
    }

    public function getRoomItems(): ?array
    {
        return $this->roomItems;
    }

    public function setRoomItems(?array $roomItems): static
    {
        $this->roomItems = $roomItems;

        return $this;
    }

    public function getRoomDirection(): array
    {
        return $this->roomDirection;
    }

    public function setRoomDirection(array $roomDirection): static
    {
        $this->roomDirection = $roomDirection;

        return $this;
    }
}
