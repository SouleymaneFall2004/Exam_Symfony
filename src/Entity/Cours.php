<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $nomCours;

    #[ORM\OneToOne(inversedBy: 'cours', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Professeur $professeur = null;

    #[ORM\OneToOne(inversedBy: 'cours', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Niveau $niveau = null;

    #[ORM\ManyToMany(targetEntity: Classe::class, mappedBy: 'cours')]
    private Collection $classes;

    public function __construct()
    {
        $this->classes = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNomCours(): string
    {
        return $this->nomCours;
    }

    public function setNomCours(string $nomCours): self
    {
        $this->nomCours = $nomCours;
        return $this;
    }

    public function getProfesseur(): ?Professeur
    {
        return $this->professeur;
    }

    public function setProfesseur(?Professeur $professeur): self
    {
        if ($this->professeur !== $professeur) {
            if ($this->professeur !== null) {
                $this->professeur->setCours(null);
            }
            $this->professeur = $professeur;
            if ($professeur !== null) {
                $professeur->setCours($this);
            }
        }
        return $this;
    }

    public function getNiveau(): ?Niveau
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveau $niveau): self
    {
        if ($this->niveau !== $niveau) {
            if ($this->niveau !== null) {
                $this->niveau->setCours(null);
            }
            $this->niveau = $niveau;
            if ($niveau !== null) {
                $niveau->setCours($this);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Classe>
     */
    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClasse(Classe $classe): self
    {
        if (!$this->classes->contains($classe)) {
            $this->classes[] = $classe;
            $classe->addCours($this);
        }
        return $this;
    }

    public function removeClasse(Classe $classe): self
    {
        if ($this->classes->removeElement($classe)) {
            $classe->removeCours($this);
        }
        return $this;
    }
}