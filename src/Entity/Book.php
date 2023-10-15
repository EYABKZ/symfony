<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $id2 = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $id3 = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $publicationDate = null;

    #[ORM\Column]
    private ?bool $enabled = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    private ?Author $author = null;

    #[ORM\ManyToMany(targetEntity: Reader::class, mappedBy: 'books')]
    private Collection $readers;



    public function __construct()
    {
        $this->readers = new ArrayCollection();
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

    public function getId2(): ?string
    {
        return $this->id2;
    }

    public function setId2(string $id2): static
    {
        $this->id2 = $id2;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(\DateTimeInterface $publicationDate): static
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): static
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): static
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection<int, Reader>
     */
    public function getReaders(): Collection
    {
        return $this->readers;
    }

    public function addReader(Reader $reader): static
    {
        if (!$this->readers->contains($reader)) {
            $this->readers->add($reader);
            $reader->addBook($this);
        }

        return $this;
    }

    public function removeReader(Reader $reader): static
    {
        if ($this->readers->removeElement($reader)) {
            $reader->removeBook($this);
        }

        return $this;
    }



}
