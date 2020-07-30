<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QcmValueRepository")
 */
class QcmValue
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Doodle", inversedBy="qcmValues")
     * @ORM\JoinColumn(nullable=false)
     */
    private $doodle;

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

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
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

    public function __toString()
    {
        return $this->getName();
    }
}
