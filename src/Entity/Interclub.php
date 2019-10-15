<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InterclubRepository")
 */
class Interclub
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateRencontre;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team")
     */
    private $team_home;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team")
     */
    private $team_ext;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $score;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Saison", inversedBy="interclubs")
     */
    private $saison;

    public function __construct()
    {
        $this->team = new ArrayCollection();
        $this->user = new ArrayCollection();
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

    public function setDateRencontre(\DateTimeInterface $dateRencontre): self
    {
        $this->dateRencontre = $dateRencontre;

        return $this;
    }

    public function getTeamHome(): ?Team
    {
        return $this->team_home;
    }

    public function setTeamHome(?Team $team_home): self
    {
        $this->team_home = $team_home;

        return $this;
    }

    public function getTeamExt(): ?Team
    {
        return $this->team_ext;
    }

    public function setTeamExt(?Team $team_ext): self
    {
        $this->team_ext = $team_ext;

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

    public function getSaison(): ?Saison
    {
        return $this->saison;
    }

    public function setSaison(?Saison $saison): self
    {
        $this->saison = $saison;

        return $this;
    }

}