<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TournoiUserRepository")
 */
class TournoiUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $inscription;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $participation;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $resultat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tournoi")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tournoi;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $partenaire;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInscription(): ?bool
    {
        return $this->inscription;
    }

    public function setInscription(?bool $inscription): self
    {
        $this->inscription = $inscription;

        return $this;
    }

    public function getParticipation(): ?bool
    {
        return $this->participation;
    }

    public function setParticipation(?bool $participation): self
    {
        $this->participation = $participation;

        return $this;
    }

    public function getResultat(): ?string
    {
        return $this->resultat;
    }

    public function setResultat(?string $resultat): self
    {
        $this->resultat = $resultat;

        return $this;
    }

    public function getTournoi(): ?Tournoi
    {
        return $this->tournoi;
    }

    public function setTournoi(?Tournoi $tournoi): self
    {
        $this->tournoi = $tournoi;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPartenaire(): ?User
    {
        return $this->partenaire;
    }

    public function setPartenaire(?User $partenaire): self
    {
        $this->partenaire = $partenaire;

        return $this;
    }
}
