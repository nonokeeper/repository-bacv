<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LienDoodleRepository")
 */
class LienDoodle
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Doodle", inversedBy="lienDoodles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $doodle;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Personne", inversedBy="lienDoodles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $personne;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item", inversedBy="lienDoodles")
     */
    private $item;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedDt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

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

    public function getPersonne(): ?Personne
    {
        return $this->personne;
    }

    public function setPersonne(?Personne $personne): self
    {
        $this->personne = $personne;

        return $this;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getUpdatedDt(): ?\DateTimeInterface
    {
        return $this->updatedDt;
    }

    public function setUpdatedDt(?\DateTimeInterface $updatedDt): self
    {
        $this->updatedDt = $updatedDt;

        return $this;
    }

    public function __toString()
    {
        return $this->getPersonne().'-'.$this->getItem().'-'.$this->getValue();
    }
}
