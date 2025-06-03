<?php

namespace App\Entity;

use App\Repository\ResultatsBrutsCRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResultatsBrutsCRepository::class)]
class ResultatsBrutsC
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

    #[ORM\ManyToOne(inversedBy: 'resultatsBrutsCs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?SousTestC $sous_test_c = null;

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

    public function getSousTestC(): ?SousTestC
    {
        return $this->sous_test_c;
    }

    public function setSousTestC(?SousTestC $sous_test_c): static
    {
        $this->sous_test_c = $sous_test_c;

        return $this;
    }
}
