<?php

namespace App\Entity;

use App\Repository\OptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OptionRepository::class)]
#[ORM\Table(name: '`option`')]
class Option
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $codopt = null;

    #[ORM\Column(length: 255)]
    private ?string $nomopt = null;

    #[ORM\OneToMany(mappedBy: 'codopt', targetEntity: Etudiant::class, orphanRemoval: true)]
    private Collection $etudiants;

    public function __construct()
    {
        $this->etudiants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodopt(): ?string
    {
        return $this->codopt;
    }

    public function setCodopt(string $codopt): static
    {
        $this->codopt = $codopt;

        return $this;
    }

    public function getNomopt(): ?string
    {
        return $this->nomopt;
    }

    public function setNomopt(string $nomopt): static
    {
        $this->nomopt = $nomopt;

        return $this;
    }

    /**
     * @return Collection<int, Etudiant>
     */
    public function getEtudiants(): Collection
    {
        return $this->etudiants;
    }

    public function addEtudiant(Etudiant $etudiant): static
    {
        if (!$this->etudiants->contains($etudiant)) {
            $this->etudiants->add($etudiant);
            $etudiant->setCodopt($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): static
    {
        if ($this->etudiants->removeElement($etudiant)) {
            // set the owning side to null (unless already changed)
            if ($etudiant->getCodopt() === $this) {
                $etudiant->setCodopt(null);
            }
        }

        return $this;
    }
}
