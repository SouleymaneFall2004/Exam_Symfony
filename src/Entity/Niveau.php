<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Niveau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $nomNiveau;

    #[ORM\OneToOne(mappedBy: 'niveau', cascade: ['persist', 'remove'])]
    private ?Cours $cours = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getNomNiveau(): string
    {
        return $this->nomNiveau;
    }

    public function setNomNiveau(string $nomNiveau): self
    {
        $this->nomNiveau = $nomNiveau;
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
                $this->cours->setNiveau(null);
            }
            $this->cours = $cours;
            if ($cours !== null) {
                $cours->setNiveau($this);
            }
        }
        return $this;
    }
}