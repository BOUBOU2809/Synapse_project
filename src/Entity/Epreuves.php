<?php

namespace App\Entity;

use App\Repository\EpreuvesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EpreuvesRepository::class)]
class Epreuves
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $code_epreuves_sportives = null;

    #[ORM\Column]
    private ?int $note_brute = null;

    #[ORM\Column]
    private ?int $cotation = null;

    #[ORM\ManyToOne(inversedBy: 'epreuves')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TestSport $test_sport = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeEpreuvesSportives(): ?int
    {
        return $this->code_epreuves_sportives;
    }

    public function setCodeEpreuvesSportives(int $code_epreuves_sportives): static
    {
        $this->code_epreuves_sportives = $code_epreuves_sportives;

        return $this;
    }

    public function getNoteBrute(): ?int
    {
        return $this->note_brute;
    }

    public function setNoteBrute(int $note_brute): static
    {
        $this->note_brute = $note_brute;

        return $this;
    }

    public function getCotation(): ?int
    {
        return $this->cotation;
    }

    public function setCotation(int $cotation): static
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
