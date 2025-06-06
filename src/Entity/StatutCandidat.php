<?php

namespace App\Entity;

use App\Repository\StatutCandidatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatutCandidatRepository::class)]
class StatutCandidat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(length: 35)]
    private ?string $libelle_court = null;

    /**
     * @var Collection<int, Candidat>
     */
    #[ORM\OneToMany(targetEntity: Candidat::class, mappedBy: 'statut')]
    private Collection $candidats;

    public function __construct()
    {
        $this->candidats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getLibelleCourt(): ?string
    {
        return $this->libelle_court;
    }

    public function setLibelleCourt(string $libelle_court): static
    {
        $this->libelle_court = $libelle_court;

        return $this;
    }

    /**
     * @return Collection<int, Candidat>
     */
    public function getCandidat(): Collection
    {
        return $this->candidats;
    }

    public function addCandidat(Candidat $candidats): static
    {
        if (!$this->candidats->contains($candidats)) {
            $this->candidats->add($candidats);
            $candidats->setStatutCandidat($this);
        }

        return $this;
    }

    public function removeCandidat(Candidat $candidats): static
    {
        if ($this->candidats->removeElement($candidats)) {
            // set the owning side to null (unless already changed)
            if ($candidats->getStatutCandidat() === $this) {
                $candidats->setStatutCandidat(null);
            }
        }

        return $this;
    }
}
