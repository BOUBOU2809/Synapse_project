<?php

namespace App\Entity;

use App\Repository\EpreuveRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EpreuveRepository::class)]
class Epreuve
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $code_epreuve_sportive = null;

    #[ORM\Column(nullable: true)]
    private ?float $note_brute = null;

    #[ORM\Column(nullable: true)]
    private ?int $cotation = null;

    #[ORM\ManyToOne(inversedBy: 'epreuves')]
    private ?TestSport $test_sport = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeEpreuveSportive(): ?int
    {
        return $this->code_epreuve_sportive;
    }

    public function setCodeEpreuveSportive(?int $code_epreuve_sportive): static
    {
        $this->code_epreuve_sportive = $code_epreuve_sportive;

        return $this;
    }

    public function getNoteBrute(): ?float
    {
        return $this->note_brute;
    }

    public function setNoteBrute(?float $note_brute): static
    {
        $this->note_brute = $note_brute;

        return $this;
    }

    public function getCotation(): ?int
    {
        return $this->cotation;
    }

    public function setCotation(?int $cotation): static
    {
        $this->cotation = $cotation;

        return $this;
    }

    public function getTestSport(): ?TestSport
    {
        return $this->test_sport;
    }

    public function setTestSport(?TestSport $test_sport): static
    {
        $this->test_sport = $test_sport;

        return $this;
    }
}
