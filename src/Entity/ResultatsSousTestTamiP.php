<?php

namespace App\Entity;

use App\Repository\ResultatsSousTestTamiPRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResultatsSousTestTamiPRepository::class)]
class ResultatsSousTestTamiP
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_item = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $valeur_response = null;

    #[ORM\Column(nullable: true)]
    private ?float $codage = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?SousTestTamiP $sous_tests = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomItem(): ?string
    {
        return $this->nom_item;
    }

    public function setNomItem(?string $nom_item): static
    {
        $this->nom_item = $nom_item;

        return $this;
    }

    public function getValeurResponse(): ?string
    {
        return $this->valeur_response;
    }

    public function setValeurResponse(?string $valeur_response): static
    {
        $this->valeur_response = $valeur_response;

        return $this;
    }

    public function getCodage(): ?float
    {
        return $this->codage;
    }

    public function setCodage(?float $codage): static
    {
        $this->codage = $codage;

        return $this;
    }

    public function getSousTests(): ?SousTestTamiP
    {
        return $this->sous_tests;
    }

    public function setSousTests(?SousTestTamiP $sous_tests): static
    {
        $this->sous_tests = $sous_tests;

        return $this;
    }
}
