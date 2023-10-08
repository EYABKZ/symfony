<?php

namespace App\Entity;

use App\Repository\ReaderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReaderRepository::class)]
class Reader
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $id3 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getId3(): ?string
    {
        return $this->id3;
    }

    public function setId3(string $id3): static
    {
        $this->id3 = $id3;

        return $this;
    }
}
