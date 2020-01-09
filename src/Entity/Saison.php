<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SaisonRepository")
 */
class Saison
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=9)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tournoi", mappedBy="saison")
     */
    private $tournois;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Team", mappedBy="saison")
     */
    private $teams;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TeamVeteran", mappedBy="saison")
     */
    private $teamVeterans;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\InterclubVeteran", mappedBy="saison")
     */
    private $interclubVeterans;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Interclub", mappedBy="saison")
     */
    private $interclubs;

    public function __construct()
    {
        $this->tournois = new ArrayCollection();
        $this->teams = new ArrayCollection();
        $this->teamVeterans = new ArrayCollection();
        $this->interclubVeterans = new ArrayCollection();
        $this->interclubs = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|Tournoi[]
     */
    public function getTournois(): Collection
    {
        return $this->tournois;
    }

    public function addTournois(Tournoi $tournois): self
    {
        if (!$this->tournois->contains($tournois)) {
            $this->tournois[] = $tournois;
            $tournois->setSaison($this);
        }

        return $this;
    }

    public function removeTournois(Tournoi $tournois): self
    {
        if ($this->tournois->contains($tournois)) {
            $this->tournois->removeElement($tournois);
            // set the owning side to null (unless already changed)
            if ($tournois->getSaison() === $this) {
                $tournois->setSaison(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Team[]
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
            $team->addSaison($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        if ($this->teams->contains($team)) {
            $this->teams->removeElement($team);
            $team->removeSaison($this);
        }

        return $this;
    }

    /**
     * @return Collection|TeamVeteran[]
     */
    public function getTeamVeterans(): Collection
    {
        return $this->teamVeterans;
    }

    public function addTeamVeteran(TeamVeteran $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
            $team->addSaison($this);
        }

        return $this;
    }

    public function removeTeamVeteran(TeamVeteran $team): self
    {
        if ($this->teams->contains($team)) {
            $this->teams->removeElement($team);
            $team->removeSaison($this);
        }

        return $this;
    }

    /**
     * @return Collection|InterclubVeteran[]
     */
    public function getInterclubVeterans(): Collection
    {
        return $this->interclubVeterans;
    }

    public function addInterclubVeteran(InterclubVeteran $interclubVeteran): self
    {
        if (!$this->interclubVeterans->contains($interclubVeteran)) {
            $this->interclubVeterans[] = $interclubVeteran;
            $interclubVeteran->setSaison($this);
        }

        return $this;
    }

    public function removeInterclubVeteran(InterclubVeteran $interclubVeteran): self
    {
        if ($this->interclubVeterans->contains($interclubVeteran)) {
            $this->interclubVeterans->removeElement($interclubVeteran);
            // set the owning side to null (unless already changed)
            if ($interclubVeteran->getSaison() === $this) {
                $interclubVeteran->setSaison(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Interclub[]
     */
    public function getInterclubs(): Collection
    {
        return $this->interclubs;
    }

    public function addInterclub(Interclub $interclub): self
    {
        if (!$this->interclubs->contains($interclub)) {
            $this->interclubs[] = $interclub;
            $interclub->setSaison($this);
        }

        return $this;
    }

    public function removeInterclub(Interclub $interclub): self
    {
        if ($this->interclubs->contains($interclub)) {
            $this->interclubs->removeElement($interclub);
            // set the owning side to null (unless already changed)
            if ($interclub->getSaison() === $this) {
                $interclub->setSaison(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        if ($this->getName()) {
            return $this->getName();
        } else return '';
    }

}