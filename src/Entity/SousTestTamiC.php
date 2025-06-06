<?php

namespace App\Entity;

use App\Repository\SousTestTamiCRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SousTestTamiCRepository::class)]
class SousTestTamiC
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_sous_test = null;

    #[ORM\ManyToOne(inversedBy: 'sous_tests')]
    private ?TestTamiC $test_tami_c = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSousTest(): ?string
    {
        return $this->nom_sous_test;
    }

    public function setNomSousTest(?string $nom_sous_test): static
    {
        $this->nom_sous_test = $nom_sous_test;

        return $this;
    }

    public function getTestTamiC(): ?TestTamiC
    {
        return $this->test_tami_c;
    }

    public function setTestTamiC(?TestTamiC $test_tami_c): static
    {
        $this->test_tami_c = $test_tami_c;

        return $this;
    }
}
