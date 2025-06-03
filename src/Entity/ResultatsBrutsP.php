<?php

namespace App\Entity;

use App\Repository\ResultatsBrutsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResultatsBrutsRepository::class)]
class ResultatsBrutsP
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_item = null;

    #[ORM\Column(length: 255)]
    private ?string $valeur_response = null;

    #[ORM\Column]
    private ?int $codage = null;

    #[ORM\ManyToOne(inversedBy: 'resultatsBruts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?SousTestP $sous_test_p = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomItem(): ?string
    {
        return $this->nom_item;
    }

    public function setNomItem(string $nom_item): static
    {
        $this->nom_item = $nom_item;

        return $this;
    }

    public function getValeurResponse(): ?string
    {
        return $this->valeur_response;
    }

    public function setValeurResponse(string $valeur_response): static
    {
        $this->valeur_response = $valeur_response;

        return $this;
    }

    public function getCodage(): ?int
    {
        return $this->codage;
    }

    public function setCodage(int $codage): static
    {
        $this->codage = $codage;

        return $this;
    }

    public function getSousTestP(): ?SousTestP
    {
        return $this->sous_test_p;
    }

    public function setSousTestP(?SousTestP $sous_test_p): static
    {
        $this->sous_test_p = $sous_test_p;

        return $this;
    }
}
