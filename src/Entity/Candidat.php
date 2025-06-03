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
    private ?int $NID = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column]
    private ?\DateTime $birth_date = null;

    #[ORM\Column(length: 255)]
    private ?string $birth_place = null;

    #[ORM\Column(length: 255)]
    private ?string $commentaires = null;

    #[ORM\ManyToOne(inversedBy: 'candidats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Session $session = null;

    #[ORM\ManyToOne(inversedBy: 'candidat')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Genre $genre = null;

    /**
     * @var Collection<int, Motif>
     */
    #[ORM\ManyToMany(targetEntity: Motif::class, mappedBy: 'candidat')]
    private Collection $motifs;

    #[ORM\ManyToOne(inversedBy: 'candidat')]
    #[ORM\JoinColumn(nullable: false)]
    private ?StatutCandidat $statutCandidat = null;

    #[ORM\ManyToOne(inversedBy: 'candidat')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TestAnglais $testAnglais = null;

    #[ORM\ManyToOne(inversedBy: 'candidat')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TestSport $testSport = null;

    #[ORM\ManyToOne(inversedBy: 'candidat')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TestTamiC $testTamiC = null;

    #[ORM\ManyToOne(inversedBy: 'candidat')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TestTamiP $testTamiP = null;

    public function __construct()
    {
        $this->motifs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNID(): ?int
    {
        return $this->NID;
    }

    public function setNID(int $NID): static
    {
        $this->NID = $NID;

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

    public function getBirthDate(): ?\DateTime
    {
        return $this->birth_date;
    }

    public function setBirthDate(\DateTime $birth_date): static
    {
        $this->birth_date = $birth_date;

        return $this;
    }

    public function getBirthPlace(): ?string
    {
        return $this->birth_place;
    }

    public function setBirthPlace(string $birth_place): static
    {
        $this->birth_place = $birth_place;

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

    public function getTestAnglais(): ?TestAnglais
    {
        return $this->testAnglais;
    }

    public function setTestAnglais(?TestAnglais $testAnglais): static
    {
        $this->testAnglais = $testAnglais;

        return $this;
    }

    public function getTestSport(): ?TestSport
    {
        return $this->testSport;
    }

    public function setTestSport(?TestSport $testSport): static
    {
        $this->testSport = $testSport;

        return $this;
    }

    public function getTestTamiC(): ?TestTamiC
    {
        return $this->testTamiC;
    }

    public function setTestTamiC(?TestTamiC $testTamiC): static
    {
        $this->testTamiC = $testTamiC;

        return $this;
    }

    public function getTestTamiP(): ?TestTamiP
    {
        return $this->testTamiP;
    }

    public function setTestTamiP(?TestTamiP $testTamiP): static
    {
        $this->testTamiP = $testTamiP;

        return $this;
    }
}
