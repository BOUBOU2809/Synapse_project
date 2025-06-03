<?php

namespace App\Entity;

use App\Repository\TestTamiPRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestTamiPRepository::class)]
class TestTamiP
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
    #[ORM\OneToMany(targetEntity: Candidat::class, mappedBy: 'testTamiP')]
    private Collection $candidat;

    /**
     * @var Collection<int, SousTestP>
     */
    #[ORM\OneToMany(targetEntity: SousTestP::class, mappedBy: 'test_tami_p')]
    private Collection $sousTestPs;

    public function __construct()
    {
        $this->candidat = new ArrayCollection();
        $this->sousTestPs = new ArrayCollection();
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
            $candidat->setTestTamiP($this);
        }

        return $this;
    }

    public function removeCandidat(Candidat $candidat): static
    {
        if ($this->candidat->removeElement($candidat)) {
            // set the owning side to null (unless already changed)
            if ($candidat->getTestTamiP() === $this) {
                $candidat->setTestTamiP(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SousTestP>
     */
    public function getSousTestPs(): Collection
    {
        return $this->sousTestPs;
    }

    public function addSousTestP(SousTestP $sousTestP): static
    {
        if (!$this->sousTestPs->contains($sousTestP)) {
            $this->sousTestPs->add($sousTestP);
            $sousTestP->setTestTamiP($this);
        }

        return $this;
    }

    public function removeSousTestP(SousTestP $sousTestP): static
    {
        if ($this->sousTestPs->removeElement($sousTestP)) {
            // set the owning side to null (unless already changed)
            if ($sousTestP->getTestTamiP() === $this) {
                $sousTestP->setTestTamiP(null);
            }
        }

        return $this;
    }
}
