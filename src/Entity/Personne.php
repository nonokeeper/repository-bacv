<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonneRepository")
 */
class Personne
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $bureau;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Doodle", inversedBy="personnes")
     */
    private $doodle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LienDoodle", mappedBy="personne")
     */
    private $lienDoodles;

    public function __construct()
    {
        $this->lienDoodles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getBureau(): ?bool
    {
        return $this->bureau;
    }

    public function setBureau(?bool $bureau): self
    {
        $this->bureau = $bureau;

        return $this;
    }

    public function getDoodle(): ?Doodle
    {
        return $this->doodle;
    }

    public function setDoodle(?Doodle $doodle): self
    {
        $this->doodle = $doodle;

        return $this;
    }

    public function __toString()
    {
        return $this->getPseudo();
    }

    /**
     * @return Collection|LienDoodle[]
     */
    public function getLienDoodles(): Collection
    {
        return $this->lienDoodles;
    }

    public function addLienDoodle(LienDoodle $lienDoodle): self
    {
        if (!$this->lienDoodles->contains($lienDoodle)) {
            $this->lienDoodles[] = $lienDoodle;
            $lienDoodle->setPersonne($this);
        }

        return $this;
    }

    public function removeLienDoodle(LienDoodle $lienDoodle): self
    {
        if ($this->lienDoodles->contains($lienDoodle)) {
            $this->lienDoodles->removeElement($lienDoodle);
            // set the owning side to null (unless already changed)
            if ($lienDoodle->getPersonne() === $this) {
                $lienDoodle->setPersonne(null);
            }
        }

        return $this;
    }
}
