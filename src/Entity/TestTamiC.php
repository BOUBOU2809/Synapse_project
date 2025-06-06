<?php

namespace App\Entity;

use App\Repository\TestTamiCRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestTamiCRepository::class)]
class TestTamiC
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_test = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $date_passage = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Candidat $candidats = null;

    /**
     * @var Collection<int, SousTestTamiC>
     */
    #[ORM\OneToMany(targetEntity: SousTestTamiC::class, mappedBy: 'test_tami_c')]
    private Collection $sous_tests;

    public function __construct()
    {
        $this->sous_tests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomTest(): ?string
    {
        return $this->nom_test;
    }

    public function setNomTest(?string $nom_test): static
    {
        $this->nom_test = $nom_test;

        return $this;
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

    public function getCandidats(): ?Candidat
    {
        return $this->candidats;
    }

    public function setCandidats(?Candidat $candidats): static
    {
        $this->candidats = $candidats;

        return $this;
    }

    /**
     * @return Collection<int, SousTestTamiC>
     */
    public function getSousTests(): Collection
    {
        return $this->sous_tests;
    }

    public function addSousTest(SousTestTamiC $sousTest): static
    {
        if (!$this->sous_tests->contains($sousTest)) {
            $this->sous_tests->add($sousTest);
            $sousTest->setTestTamiC($this);
        }

        return $this;
    }

    public function removeSousTest(SousTestTamiC $sousTest): static
    {
        if ($this->sous_tests->removeElement($sousTest)) {
            // set the owning side to null (unless already changed)
            if ($sousTest->getTestTamiC() === $this) {
                $sousTest->setTestTamiC(null);
            }
        }

        return $this;
    }
}
