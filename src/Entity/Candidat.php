<?php

namespace App\Entity;

use App\Repository\CandidatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CandidatRepository::class)]
class Candidat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nid = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column]
    private ?\DateTime $date_naissance = null;

    #[ORM\Column(length: 255)]
    private ?string $lieu_naissance = null;

    #[ORM\Column(length: 255)]
    private ?string $commentaires = null;

    #[ORM\ManyToOne(inversedBy: 'candidats')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Session $session = null;

    #[ORM\ManyToOne(inversedBy: 'candidats')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Genre $genre = null;

    /**
     * @var Collection<int, Motif>
     */
    #[ORM\ManyToMany(targetEntity: Motif::class, mappedBy: 'candidats')]
    private Collection $motifs;

    #[ORM\ManyToOne(inversedBy: 'candidats')]
    #[ORM\JoinColumn(nullable: true)]
    private ?StatutCandidat $statutCandidat = null;

    public function __construct()
    {
        $this->motifs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNid(): ?int
    {
        return $this->nid;
    }

    public function setNid(int $nid): static
    {
        $this->nid = $nid;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTime
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(\DateTime $date_naissance): static
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getLieuNaissance(): ?string
    {
        return $this->lieu_naissance;
    }

    public function setLieuNaissance(string $lieu_naissance): static
    {
        $this->lieu_naissance = $lieu_naissance;

        return $this;
    }

    public function getCommentaires(): ?string
    {
        return $this->commentaires;
    }

    public function setCommentaires(string $commentaires): static
    {
        $this->commentaires = $commentaires;

        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): static
    {
        $this->session = $session;

        return $this;
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * @return Collection<int, Motif>
     */
    public function getMotifs(): Collection
    {
        return $this->motifs;
    }

    public function addMotif(Motif $motif): static
    {
        if (!$this->motifs->contains($motif)) {
            $this->motifs->add($motif);
            $motif->addCandidat($this);
        }

        return $this;
    }

    public function removeMotif(Motif $motif): static
    {
        if ($this->motifs->removeElement($motif)) {
            $motif->removeCandidat($this);
        }

        return $this;
    }

    public function getStatutCandidat(): ?StatutCandidat
    {
        return $this->statutCandidat;
    }

    public function setStatutCandidat(?StatutCandidat $statutCandidat): static
    {
        $this->statutCandidat = $statutCandidat;

        return $this;
    }
}
