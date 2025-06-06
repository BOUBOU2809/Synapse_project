<?php

namespace App\Entity;

use App\Repository\SousTestTamiPRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SousTestTamiPRepository::class)]
class SousTestTamiP
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_sous_test = null;

    #[ORM\ManyToOne(inversedBy: 'sous_tests')]
    private ?TestTamiP $test_tami_p = null;

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

    public function getTestTamiP(): ?TestTamiP
    {
        return $this->test_tami_p;
    }

    public function setTestTamiP(?TestTamiP $test_tami_p): static
    {
        $this->test_tami_p = $test_tami_p;

        return $this;
    }
}
