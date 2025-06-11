<?php

namespace App\Entity;

use App\Repository\IterationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IterationRepository::class)]
class Iteration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $decisionDate = null;

    #[ORM\Column]
    private ?\DateTime $startDate = null;

    #[ORM\Column]
    private ?\DateTime $endDate = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    /**
     * @var Collection<int, Session>
     */
    #[ORM\ManyToMany(targetEntity: Session::class, inversedBy: 'iterations')]
    private Collection $session;

    #[ORM\ManyToOne(inversedBy: 'iteration')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProcessusEvaluation $processusEvaluation = null;

    public function __construct()
    {
        $this->session = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDecisionDate(): ?\DateTime
    {
        return $this->decisionDate;
    }

    public function setDecisionDate(\DateTime $decisionDate): static
    {
        $this->decisionDate = $decisionDate;

        return $this;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTime $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTime $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, Session>
     */
    public function getSession(): Collection
    {
        return $this->session;
    }

    public function addSession(Session $session): static
    {
        if (!$this->session->contains($session)) {
            $this->session->add($session);
        }

        return $this;
    }

    public function removeSession(Session $session): static
    {
        $this->session->removeElement($session);

        return $this;
    }

    public function getProcessusEvaluation(): ?ProcessusEvaluation
    {
        return $this->processusEvaluation;
    }

    public function setProcessusEvaluation(?ProcessusEvaluation $processusEvaluation): static
    {
        $this->processusEvaluation = $processusEvaluation;

        return $this;
    }
}
