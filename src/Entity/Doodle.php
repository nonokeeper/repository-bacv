<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DoodleRepository")
 */
class Doodle
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @param string $md5
     */
    private $md5;

    /**
     * @param string $typeValue
     */
    private $typeValue;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $maxPersonnes;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $beginDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Item", mappedBy="doodle")
     */
    private $items;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Personne", mappedBy="doodle")
     */
    private $personnes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LienDoodle", mappedBy="doodle")
     */
    private $lienDoodles;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\QcmValue", mappedBy="doodle", orphanRemoval=true)
     */
    private $qcmValues;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->personnes = new ArrayCollection();
        $this->lienDoodles = new ArrayCollection();
        $this->qcmValues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMd5(): ?string
    {
        return md5($this->id);
    }

    public function getTypeValue(): ?string
    {
        $typeValue = '';
        switch ($this->type) {
            case 'text':
                $typeValue = 'Saisie libre';
                break;
           case 'checkbox':
            $typeValue = 'Cases à cocher';
                break;
           case 'number':
            $typeValue = 'Nombre';
                break;   
        }
        return $typeValue;
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

    public function getMaxPersonnes(): ?int
    {
        return $this->maxPersonnes;
    }

    public function setMaxPersonnes(?int $maxPersonnes): self
    {
        $this->maxPersonnes = $maxPersonnes;

        return $this;
    }

    public function getBeginDate(): ?\DateTimeInterface
    {
        return $this->beginDate;
    }

    public function setBeginDate(?\DateTimeInterface $beginDate): self
    {
        $this->beginDate = $beginDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection|Item[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setDoodle($this);
        }

        return $this;
    }

    public function removeItem(Item $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
            // set the owning side to null (unless already changed)
            if ($item->getDoodle() === $this) {
                $item->setDoodle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Personne[]
     */
    public function getPersonnes(): Collection
    {
        return $this->personnes;
    }

    public function addPersonne(Personne $personne): self
    {
        if (!$this->personnes->contains($personne)) {
            $this->personnes[] = $personne;
            $personne->setDoodle($this);
        }

        return $this;
    }

    public function removePersonne(Personne $personne): self
    {
        if ($this->personnes->contains($personne)) {
            $this->personnes->removeElement($personne);
            // set the owning side to null (unless already changed)
            if ($personne->getDoodle() === $this) {
                $personne->setDoodle(null);
            }
        }

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
            $lienDoodle->setDoodle($this);
        }

        return $this;
    }

    public function removeLienDoodle(LienDoodle $lienDoodle): self
    {
        if ($this->lienDoodles->contains($lienDoodle)) {
            $this->lienDoodles->removeElement($lienDoodle);
            // set the owning side to null (unless already changed)
            if ($lienDoodle->getDoodle() === $this) {
                $lienDoodle->setDoodle(null);
            }
        }

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|QcmValue[]
     */
    public function getQcmValues(): Collection
    {
        return $this->qcmValues;
    }

    public function addQcmValue(QcmValue $qcmValue): self
    {
        if (!$this->qcmValues->contains($qcmValue)) {
            $this->qcmValues[] = $qcmValue;
            $qcmValue->setDoodle($this);
        }

        return $this;
    }

    public function removeQcmValue(QcmValue $qcmValue): self
    {
        if ($this->qcmValues->contains($qcmValue)) {
            $this->qcmValues->removeElement($qcmValue);
            // set the owning side to null (unless already changed)
            if ($qcmValue->getDoodle() === $this) {
                $qcmValue->setDoodle(null);
            }
        }

        return $this;
    }
}
