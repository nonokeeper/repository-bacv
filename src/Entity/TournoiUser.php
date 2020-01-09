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
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $resultatSimple;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $resultatDouble;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $resultatMixte;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbTableaux;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $inscriptionSimple;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $inscriptionDouble;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $inscriptionMixte;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $participationSimple;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $participationDouble;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $participationMixte;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $partenaireDouble;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $partenaireMixte;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $InscriptionConfirmee;

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

    public function getResultatSimple(): ?string
    {
        return $this->resultatSimple;
    }

    public function setResultatSimple(?string $resultatSimple): self
    {
        $this->resultatSimple = $resultatSimple;

        return $this;
    }

    public function getResultatDouble(): ?string
    {
        return $this->resultatDouble;
    }

    public function setResultatDouble(?string $resultatDouble): self
    {
        $this->resultatDouble = $resultatDouble;

        return $this;
    }

    public function getResultatMixte(): ?string
    {
        return $this->resultatMixte;
    }

    public function setResultatMixte(?string $resultatMixte): self
    {
        $this->resultatMixte = $resultatMixte;

        return $this;
    }

    public function getNbTableaux(): ?int
    {
        return $this->nbTableaux;
    }

    public function setNbTableaux(?int $nbTableaux): self
    {
        $this->nbTableaux = $nbTableaux;

        return $this;
    }

    public function getInscriptionSimple(): ?bool
    {
        return $this->inscriptionSimple;
    }

    public function setInscriptionSimple(?bool $inscriptionSimple): self
    {
        $this->inscriptionSimple = $inscriptionSimple;

        return $this;
    }

    public function getInscriptionDouble(): ?bool
    {
        return $this->inscriptionDouble;
    }

    public function setInscriptionDouble(?bool $inscriptionDouble): self
    {
        $this->inscriptionDouble = $inscriptionDouble;

        return $this;
    }

    public function getInscriptionMixte(): ?bool
    {
        return $this->inscriptionMixte;
    }

    public function setInscriptionMixte(?bool $inscriptionMixte): self
    {
        $this->inscriptionMixte = $inscriptionMixte;

        return $this;
    }

    public function getParticipationSimple(): ?bool
    {
        return $this->participationSimple;
    }

    public function setParticipationSimple(?bool $participationSimple): self
    {
        $this->participationSimple = $participationSimple;

        return $this;
    }

    public function getParticipationDouble(): ?bool
    {
        return $this->participationDouble;
    }

    public function setParticipationDouble(?bool $participationDouble): self
    {
        $this->participationDouble = $participationDouble;

        return $this;
    }

    public function getParticipationMixte(): ?bool
    {
        return $this->participationMixte;
    }

    public function setParticipationMixte(?bool $participationMixte): self
    {
        $this->participationMixte = $participationMixte;

        return $this;
    }

    public function getPartenaireDouble(): ?User
    {
        return $this->partenaireDouble;
    }

    public function setPartenaireDouble(?User $partenaireDouble): self
    {
        $this->partenaireDouble = $partenaireDouble;

        return $this;
    }

    public function getPartenaireMixte(): ?User
    {
        return $this->partenaireMixte;
    }

    public function setPartenaireMixte(?User $partenaireMixte): self
    {
        $this->partenaireMixte = $partenaireMixte;

        return $this;
    }

    public function getInscriptionConfirmee(): ?bool
    {
        return $this->InscriptionConfirmee;
    }

    public function setInscriptionConfirmee(?bool $InscriptionConfirmee): self
    {
        $this->InscriptionConfirmee = $InscriptionConfirmee;

        return $this;
    }
}
