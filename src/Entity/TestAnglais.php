<?php

namespace App\Entity;

use App\Repository\TestAnglaisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestAnglaisRepository::class)]
class TestAnglais
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $date_passage = null;

    #[ORM\Column]
    private ?int $note_brute = null;

    /**
     * @var Collection<int, Candidat>
     */
    #[ORM\OneToMany(targetEntity: Candidat::class, mappedBy: 'testAnglais')]
    private Collection $candidat;

    public function __construct()
    {
        $this->candidat = new ArrayCollection();
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

    public function getNoteBrute(): ?int
    {
        return $this->note_brute;
    }

    public function setNoteBrute(int $note_brute): static
    {
        $this->note_brute = $note_brute;

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
            $candidat->setTestAnglais($this);
        }

        return $this;
    }

    public function removeCandidat(Candidat $candidat): static
    {
        if ($this->candidat->removeElement($candidat)) {
            // set the owning side to null (unless already changed)
            if ($candidat->getTestAnglais() === $this) {
                $candidat->setTestAnglais(null);
            }
        }

        return $this;
    }
}
