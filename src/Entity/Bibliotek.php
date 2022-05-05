<?php

namespace App\Entity;

use App\Repository\BibliotekRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BibliotekRepository::class)]
class Bibliotek
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $titel;

    #[ORM\Column(type: 'integer')]
    private $ISBN;

    #[ORM\Column(type: 'string', length: 255)]
    private $författare;

    #[ORM\Column(type: 'string', length: 255)]
    private $bild;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitel(): ?string
    {
        return $this->titel;
    }

    public function setTitel(string $titel): self
    {
        $this->titel = $titel;

        return $this;
    }

    public function getISBN(): ?string
    {
        return $this->ISBN;
    }

    public function setISBN(string $ISBN): self
    {
        $this->ISBN = $ISBN;

        return $this;
    }

    public function getFörfattare(): ?string
    {
        return $this->författare;
    }

    public function setFörfattare(string $författare): self
    {
        $this->författare = $författare;

        return $this;
    }

    public function getBild(): ?string
    {
        return $this->bild;
    }

    public function setBild(string $bild): self
    {
        $this->bild = $bild;

        return $this;
    }
}
