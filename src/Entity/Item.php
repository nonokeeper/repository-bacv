<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ItemRepository")
 */
class Item
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Doodle", inversedBy="items")
     */
    private $doodle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LienDoodle", mappedBy="item")
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
        return $this->getName();
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
            $lienDoodle->setItem($this);
        }

        return $this;
    }

    public function removeLienDoodle(LienDoodle $lienDoodle): self
    {
        if ($this->lienDoodles->contains($lienDoodle)) {
            $this->lienDoodles->removeElement($lienDoodle);
            // set the owning side to null (unless already changed)
            if ($lienDoodle->getItem() === $this) {
                $lienDoodle->setItem(null);
            }
        }

        return $this;
    }
}
