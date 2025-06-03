<?php

namespace App\Entity;

use App\Repository\SousTestCRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SousTestCRepository::class)]
class SousTestC
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_sous_test = null;

    #[ORM\ManyToOne(inversedBy: 'sousTestCs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TestTamiC $test_tami_c = null;

    /**
     * @var Collection<int, ResultatsBrutsC>
     */
    #[ORM\OneToMany(targetEntity: ResultatsBrutsC::class, mappedBy: 'sous_test_c')]
    private Collection $resultatsBrutsCs;

    public function __construct()
    {
        $this->resultatsBrutsCs = new ArrayCollection();
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

    public function getTestTamiC(): ?TestTamiC
    {
        return $this->test_tami_c;
    }

    public function setTestTamiC(?TestTamiC $test_tami_c): static
    {
        $this->test_tami_c = $test_tami_c;

        return $this;
    }

    /**
     * @return Collection<int, ResultatsBrutsC>
     */
    public function getResultatsBrutsCs(): Collection
    {
        return $this->resultatsBrutsCs;
    }

    public function addResultatsBrutsC(ResultatsBrutsC $resultatsBrutsC): static
    {
        if (!$this->resultatsBrutsCs->contains($resultatsBrutsC)) {
            $this->resultatsBrutsCs->add($resultatsBrutsC);
            $resultatsBrutsC->setSousTestC($this);
        }

        return $this;
    }

    public function removeResultatsBrutsC(ResultatsBrutsC $resultatsBrutsC): static
    {
        if ($this->resultatsBrutsCs->removeElement($resultatsBrutsC)) {
            // set the owning side to null (unless already changed)
            if ($resultatsBrutsC->getSousTestC() === $this) {
                $resultatsBrutsC->setSousTestC(null);
            }
        }

        return $this;
    }
}
