<?php

namespace App\Entity;

use App\Repository\HighscoreRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HighscoreRepository::class)]
class Highscore
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $playername;

    #[ORM\Column(type: 'integer')]
    private $points;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayername(): ?string
    {
        return $this->playername;
    }

    public function setPlayername(string $playername): self
    {
        $this->playername = $playername;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): self
    {
        $this->points = $points;

        return $this;
    }
}
