<?php

namespace App\Entity;

use App\Repository\ProcessusEvaluationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProcessusEvaluationRepository::class)]
class ProcessusEvaluation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le nom de votre processus de peut pas être vide')]
    private ?string $nom_processus = null;

    /**
     * @var Collection<int, Iteration>
     */
    #[ORM\OneToMany(targetEntity: Iteration::class, mappedBy: 'processusEvaluation')]
    private Collection $iteration;

    public function __construct()
    {
        $this->iteration = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProcessus(): ?string
    {
        return $this->nom_processus;
    }

    public function setNomProcessus(string $nom_processus): static
    {
        $this->nom_processus = $nom_processus;

        return $this;
    }

    /**
     * @return Collection<int, Iteration>
     */
    public function getIteration(): Collection
    {
        return $this->iteration;
    }

    public function addIteration(Iteration $iteration): static
    {
        if (!$this->iteration->contains($iteration)) {
            $this->iteration->add($iteration);
            $iteration->setProcessusEvaluation($this);
        }

        return $this;
    }

    public function removeIteration(Iteration $iteration): static
    {
        if ($this->iteration->removeElement($iteration)) {
            // set the owning side to null (unless already changed)
            if ($iteration->getProcessusEvaluation() === $this) {
                $iteration->setProcessusEvaluation(null);
            }
        }

        return $this;
    }
}
