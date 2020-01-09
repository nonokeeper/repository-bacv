<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InterclubVeteranRepository")
 */
class InterclubVeteran
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateRencontre;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Saison", inversedBy="interclubVeterans")
     */
    private $saison;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $score;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TeamVeteran")
     */
    private $team_home;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TeamVeteran")
     */
    private $team_ext;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lieu", inversedBy="interclubVeterans")
     */
    private $lieu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $location;

    public function __construct()
    {
        $this->team = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDateRencontre(): ?\DateTimeInterface
    {
        return $this->dateRencontre;
    }

    public function setDateRencontre(?\DateTimeInterface $dateRencontre): self
    {
        $this->dateRencontre = $dateRencontre;

        return $this;
    }

    public function getSaison(): ?Saison
    {
        return $this->saison;
    }

    public function setSaison(?Saison $saison): self
    {
        $this->saison = $saison;

        return $this;
    }

    public function getScore(): ?string
    {
        return $this->score;
    }

    public function setScore(?string $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getTeamHome(): ?TeamVeteran
    {
        return $this->team_home;
    }

    public function setTeamHome(?TeamVeteran $team_home): self
    {
        $this->team_home = $team_home;

        return $this;
    }

    public function getTeamExt(): ?TeamVeteran
    {
        return $this->team_ext;
    }

    public function setTeamExt(?TeamVeteran $team_ext): self
    {
        $this->team_ext = $team_ext;

        return $this;
    }

    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    public function setLieu(?Lieu $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function __toString()
    {
        if ($this->getName()) {
            return $this->getName();
        } else return '';
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

}