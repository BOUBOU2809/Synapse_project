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

    #[ORM\Column(length: 255)]
    private ?string $nom_test = null;

    #[ORM\Column]
    private ?\DateTime $date_passage = null;

    /**
     * @var Collection<int, Candidat>
     */
    #[ORM\OneToMany(targetEntity: Candidat::class, mappedBy: 'testTamiC')]
    private Collection $candidat;

    /**
     * @var Collection<int, SousTestC>
     */
    #[ORM\OneToMany(targetEntity: SousTestC::class, mappedBy: 'test_tami_c')]
    private Collection $sousTestCs;

    public function __construct()
    {
        $this->candidat = new ArrayCollection();
        $this->sousTestCs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomTest(): ?string
    {
        return $this->nom_test;
    }

    public function setNomTest(string $nom_test): static
    {
        $this->nom_test = $nom_test;

        return $this;
    }

    public function getDatePassage(): ?\DateTime
    {
        return $this->date_passage;
    }

    public function setDatePassage(\DateTime $date_passage): static
    {
        $this->date_passage = $date_passage;

        return $this;
    }

    /**
     * @return Collection<int, Candidat>
     */
    public function getCandidat(): Collection
    {
        return $this->candidat;
    }

    public function addCandidat(Candidat $candidat): static
    {
        if (!$this->candidat->contains($candidat)) {
            $this->candidat->add($candidat);
            $candidat->setTestTamiC($this);
        }

        return $this;
    }

    public function removeCandidat(Candidat $candidat): static
    {
        if ($this->candidat->removeElement($candidat)) {
            // set the owning side to null (unless already changed)
            if ($candidat->getTestTamiC() === $this) {
                $candidat->setTestTamiC(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SousTestC>
     */
    public function getSousTestCs(): Collection
    {
        return $this->sousTestCs;
    }

    public function addSousTestC(SousTestC $sousTestC): static
    {
        if (!$this->sousTestCs->contains($sousTestC)) {
            $this->sousTestCs->add($sousTestC);
            $sousTestC->setTestTamiC($this);
        }

        return $this;
    }

    public function removeSousTestC(SousTestC $sousTestC): static
    {
        if ($this->sousTestCs->removeElement($sousTestC)) {
            // set the owning side to null (unless already changed)
            if ($sousTestC->getTestTamiC() === $this) {
                $sousTestC->setTestTamiC(null);
            }
        }

        return $this;
    }
}
