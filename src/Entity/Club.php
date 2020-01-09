<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClubRepository")
 */
class Club
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="club")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Team", mappedBy="club")
     */
    private $teams;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TeamVeteran", mappedBy="club")
     */
    private $teamVeterans;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Lieu", mappedBy="club")
     */
    private $lieux;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->interclubs = new ArrayCollection();
        $this->teams = new ArrayCollection();
        $this->teamVeterans = new ArrayCollection();
        $this->lieux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
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
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setClub($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getClub() === $this) {
                $user->setClub(null);
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
            $team->setClub($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        if ($this->teams->contains($team)) {
            $this->teams->removeElement($team);
            if ($team->getClub() === $this) {
                $team->setClub(null);
            }
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

    public function addTeamVeteran(TeamVeteran $teamVeteran): self
    {
        if (!$this->teamVeterans->contains($teamVeteran)) {
            $this->teamVeterans[] = $teamVeteran;
            $teamVeteran->setClub($this);
        }

        return $this;
    }

    public function removeTeamVeteran(TeamVeteran $teamVeteran): self
    {
        if ($this->teamVeterans->contains($teamVeteran)) {
            $this->teamVeterans->removeElement($teamVeteran);
            // set the owning side to null (unless already changed)
            if ($teamVeteran->getClub() === $this) {
                $teamVeteran->setClub(null);
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

    /**
     * @return Collection|Lieu[]
     */
    public function getLieux(): Collection
    {
        return $this->lieux;
    }

    public function addLieux(Lieu $lieux): self
    {
        if (!$this->lieux->contains($lieux)) {
            $this->lieux[] = $lieux;
            $lieux->setClub($this);
        }

        return $this;
    }

    public function removeLieux(Lieu $lieux): self
    {
        if ($this->lieux->contains($lieux)) {
            $this->lieux->removeElement($lieux);
            // set the owning side to null (unless already changed)
            if ($lieux->getClub() === $this) {
                $lieux->setClub(null);
            }
        }

        return $this;
    }

}