<?php

namespace App\Entity;

use App\Repository\TestAnglaisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestAnglaisRepository::class)]
class TestAnglais
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $date_passage = null;

    #[ORM\Column(nullable: true)]
    private ?int $note_brute = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Candidat $candidats = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatePassage(): ?\DateTime
    {
        return $this->date_passage;
    }

    public function setDatePassage(?\DateTime $date_passage): static
    {
        $this->date_passage = $date_passage;

        return $this;
    }

    public function getNoteBrute(): ?int
    {
        return $this->note_brute;
    }

    public function setNoteBrute(?int $note_brute): static
    {
        $this->note_brute = $note_brute;

        return $this;
    }

    public function getCandidats(): ?Candidat
    {
        return $this->candidats;
    }

    public function setCandidats(?Candidat $candidats): static
    {
        $this->candidats = $candidats;

        return $this;
    }
}
