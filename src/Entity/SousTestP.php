<?php

namespace App\Entity;

use App\Repository\SousTestPRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SousTestPRepository::class)]
class SousTestP
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_sous_test = null;

    #[ORM\ManyToOne(inversedBy: 'sousTestPs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TestTamiP $test_tami_p = null;

    /**
     * @var Collection<int, ResultatsBrutsP>
     */
    #[ORM\OneToMany(targetEntity: ResultatsBrutsP::class, mappedBy: 'sous_test_p')]
    private Collection $resultatsBruts;

    public function __construct()
    {
        $this->resultatsBruts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSousTest(): ?string
    {
        return $this->nom_sous_test;
    }

    public function setNomSousTest(string $nom_sous_test): static
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

    /**
     * @return Collection<int, ResultatsBrutsP>
     */
    public function getResultatsBruts(): Collection
    {
        return $this->resultatsBruts;
    }

    public function addResultatsBrut(ResultatsBrutsP $resultatsBrut): static
    {
        if (!$this->resultatsBruts->contains($resultatsBrut)) {
            $this->resultatsBruts->add($resultatsBrut);
            $resultatsBrut->setSousTestP($this);
        }

        return $this;
    }

    public function removeResultatsBrut(ResultatsBrutsP $resultatsBrut): static
    {
        if ($this->resultatsBruts->removeElement($resultatsBrut)) {
            // set the owning side to null (unless already changed)
            if ($resultatsBrut->getSousTestP() === $this) {
                $resultatsBrut->setSousTestP(null);
            }
        }

        return $this;
    }
}
