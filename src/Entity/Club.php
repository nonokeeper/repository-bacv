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
     * @ORM\Column(type="string", length=10)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="club", orphanRemoval=true)
     */
    private $users;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Lieu", inversedBy="club", cascade={"persist", "remove"})
     */
    private $lieu;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Lieu2", inversedBy="club", cascade={"persist", "remove"})
     */
    private $lieu2;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Team", mappedBy="club", orphanRemoval=true)
     */
    private $teams;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TeamVeteran", mappedBy="club", orphanRemoval=true)
     */
    private $teamVeterans;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->interclubs = new ArrayCollection();
        $this->teams = new ArrayCollection();
        $this->teamVeterans = new ArrayCollection();
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

    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    public function setLieu(Lieu $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getLieu2(): ?Lieu2
    {
        return $this->lieu2;
    }

    public function setLieu2(?Lieu2 $lieu2): self
    {
        $this->lieu2 = $lieu2;

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
            // set the owning side to null (unless already changed)
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

}