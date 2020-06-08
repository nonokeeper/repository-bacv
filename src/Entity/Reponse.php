<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReponseRepository")
 */
class Reponse
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $validatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="reponses")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Question", inversedBy="reponses")
     */
    private $question;

    /**
     * @ORM\Column(type="array")
     */
    private $choix = [];

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Sondage", inversedBy="reponses")
     */
    private $sondage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValidatedAt(): ?\DateTimeInterface
    {
        return $this->validatedAt;
    }

    public function setValidatedAt(\DateTimeInterface $validatedAt): self
    {
        $this->validatedAt = $validatedAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getChoix(): ?array
    {
        return $this->choix;
    }

    public function setChoix(array $choix): self
    {
        $this->choix = $choix;

        return $this;
    }

    public function getSondage(): ?Sondage
    {
        return $this->sondage;
    }

    public function setSondage(?Sondage $sondage): self
    {
        $this->sondage = $sondage;

        return $this;
    }

    public function __toString()
    {
        return $this->getUser()->getUsername();
    }
}
