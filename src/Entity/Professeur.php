<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Professeur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $nomProfesseur;

    #[ORM\OneToOne(mappedBy: 'professeur', cascade: ['persist', 'remove'])]
    private ?Cours $cours = null;

    // Getters et setters

    public function getId(): int
    {
        return $this->id;
    }

    public function getNomProfesseur(): string
    {
        return $this->nomProfesseur;
    }

    public function setNomProfesseur(string $nomProfesseur): self
    {
        $this->nomProfesseur = $nomProfesseur;
        return $this;
    }

    public function getCours(): ?Cours
    {
        return $this->cours;
    }

    public function setCours(?Cours $cours): self
    {
        if ($this->cours !== $cours) {
            if ($this->cours !== null) {
                $this->cours->setProfesseur(null);
            }
            // Associe le nouveau cours
            $this->cours = $cours;
            if ($cours !== null) {
                $cours->setProfesseur($this);
            }
        }
        return $this;
    }
}