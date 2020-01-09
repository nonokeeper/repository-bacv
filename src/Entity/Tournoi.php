<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use \Datetime;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TournoiRepository")
 */
class Tournoi
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
     * @ORM\Column(type="date")
     */
    private $date_debut;

    /**
     * @ORM\Column(type="date")
     */
    private $date_fin;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $lieu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lien_inscription;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $classements;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $categories;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $tableaux;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_inscription;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lien_convocation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lien_description;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Saison", inversedBy="tournois")
     * @ORM\JoinColumn(nullable=false)
     */
    private $saison;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Club")
     */
    private $club;

    /**
     * @var string Variable pour dire si le statut du Tournoi : terminé / à venir ou inscriptions closes
     */
    private $statut;

    public function __construct()
    {
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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getLienInscription(): ?string
    {
        return $this->lien_inscription;
    }

    public function setLienInscription(?string $lien_inscription): self
    {
        $this->lien_inscription = $lien_inscription;

        return $this;
    }

    public function getClassements(): ?string
    {
        return $this->classements;
    }

    public function setClassements(?string $classements): self
    {
        $this->classements = $classements;

        return $this;
    }

    public function getCategories(): ?string
    {
        return $this->categories;
    }

    public function setCategories(?string $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    public function getTableaux(): ?string
    {
        return $this->tableaux;
    }

    public function setTableaux(string $tableaux): self
    {
        $this->tableaux = $tableaux;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->date_inscription;
    }

    public function setDateInscription(?\DateTimeInterface $date_inscription): self
    {
        $this->date_inscription = $date_inscription;

        return $this;
    }

    public function getLienConvocation(): ?string
    {
        return $this->lien_convocation;
    }

    public function setLienConvocation(?string $lien_convocation): self
    {
        $this->lien_convocation = $lien_convocation;

        return $this;
    }

    public function getLienDescription(): ?string
    {
        return $this->lien_description;
    }

    public function setLienDescription(?string $lien_description): self
    {
        $this->lien_description = $lien_description;

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

    public function getSaison(): ?Saison
    {
        return $this->saison;
    }

    public function setSaison(?Saison $saison): self
    {
        $this->saison = $saison;

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
     * @return string
     */
    public function getStatut(): ?string
    {
        // valeur qui dépend de date_inscription / date_debut / date_fin
        // retour "closed" si date courante > date_fin
        // retour "open" si date courante < date_inscription
        // retour "soon" si date courante > date_inscription et date courante < date_fin
        $now = new DateTime('now');

        if ($now >= $this->getDateFin()) {
            $this->statut = 'closed';
        } elseif ($now > $this->getDateInscription() or !$this->getDateInscription()) {
            $this->statut = 'soon';
        } else {
            $this->statut = 'open';
        }
        
        return $this->statut;
    }

    /**
     * @param string $statut
     * @return Tournoi
     */
    public function setStatut(string $statut): Tournoi
    {
        $this->statut = $statut;

        return $this;
    }

    public function __toString()
    {
        if ($this->getName()) {
            return $this->getName();
        } else return '';
    }
}