<?php

namespace App\Entity;

use App\Repository\TestSportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestSportRepository::class)]
class TestSport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $date_passage = null;

    /**
     * @var Collection<int, Candidat>
     */
    #[ORM\OneToMany(targetEntity: Candidat::class, mappedBy: 'testSport')]
    private Collection $candidat;

    /**
     * @var Collection<int, Epreuves>
     */
    #[ORM\OneToMany(targetEntity: Epreuves::class, mappedBy: 'test_sport')]
    private Collection $epreuves;

    public function __construct()
    {
        $this->candidat = new ArrayCollection();
        $this->epreuves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $candidat->setTestSport($this);
        }

        return $this;
    }

    public function removeCandidat(Candidat $candidat): static
    {
        if ($this->candidat->removeElement($candidat)) {
            // set the owning side to null (unless already changed)
            if ($candidat->getTestSport() === $this) {
                $candidat->setTestSport(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Epreuves>
     */
    public function getEpreuves(): Collection
    {
        return $this->epreuves;
    }

    public function addEpreufe(Epreuves $epreufe): static
    {
        if (!$this->epreuves->contains($epreufe)) {
            $this->epreuves->add($epreufe);
            $epreufe->setTestSport($this);
        }

        return $this;
    }

    public function removeEpreufe(Epreuves $epreufe): static
    {
        if ($this->epreuves->removeElement($epreufe)) {
            // set the owning side to null (unless already changed)
            if ($epreufe->getTestSport() === $this) {
                $epreufe->setTestSport(null);
            }
        }

        return $this;
    }
}
