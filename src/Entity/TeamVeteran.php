<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamVeteranRepository")
 */
class TeamVeteran
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
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Saison", inversedBy="teamVeterans")
     */
    private $saison;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Club", inversedBy="teamVeterans")
     * @ORM\JoinColumn(nullable=false)
     */
    private $club;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="teamVeteran")
     */
    private $users;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="teamVeteranManaged")
     */
    private $capitaine;

    public function __construct()
    {
        $this->saison = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|Saison[]
     */
    public function getSaison(): Collection
    {
        return $this->saison;
    }

    public function addSaison(Saison $saison): self
    {
        if (!$this->saison->contains($saison)) {
            $this->saison[] = $saison;
        }

        return $this;
    }

    public function removeSaison(Saison $saison): self
    {
        if ($this->saison->contains($saison)) {
            $this->saison->removeElement($saison);
        }

        return $this;
    }

    public function getClub(): ?Club
    {
        return $this->club;
    }

    public function setClub(?Club $club): self
    {
        $this->club = $club;

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
            $user->setTeamVeteran($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getTeamVeteran() === $this) {
                $user->setTeamVeteran(null);
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

    public function getCapitaine(): ?User
    {
        return $this->capitaine;
    }

    public function setCapitaine(?User $capitaine): self
    {
        $this->capitaine = $capitaine;

        return $this;
    }

}