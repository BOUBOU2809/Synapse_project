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

    #[ORM\Column(nullable: true)]
    private ?\DateTime $date_passage = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Candidat $candidats = null;

    /**
     * @var Collection<int, Epreuve>
     */
    #[ORM\OneToMany(targetEntity: Epreuve::class, mappedBy: 'test_sport')]
    private Collection $epreuves;

    public function __construct()
    {
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
     * @return Collection<int, Epreuve>
     */
    public function getEpreuves(): Collection
    {
        return $this->epreuves;
    }

    public function addEpreufe(Epreuve $epreufe): static
    {
        if (!$this->epreuves->contains($epreufe)) {
            $this->epreuves->add($epreufe);
            $epreufe->setTestSport($this);
        }

        return $this;
    }

    public function removeEpreufe(Epreuve $epreufe): static
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
