<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InterclubRepository")
 */
class Interclub
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateRencontre;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team")
     */
    private $team_home;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team")
     */
    private $team_ext;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $score;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Saison", inversedBy="interclubs")
     */
    private $saison;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lieu", inversedBy="interclubs")
     */
    private $lieu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $SH1;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $SH2;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $SH3;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $SH4;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $SD;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $DDJoueuse1;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $DDJoueuse2;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $DH1Joueur1;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $DH1Joueur2;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $DH2Joueur1;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $DH2Joueur2;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $DMXJoueur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $DMXJoueuse;

    public function __construct()
    {
        $this->team = new ArrayCollection();
        $this->user = new ArrayCollection();
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

    public function getDateRencontre(): ?\DateTimeInterface
    {
        return $this->dateRencontre;
    }

    public function setDateRencontre(\DateTimeInterface $dateRencontre): self
    {
        $this->dateRencontre = $dateRencontre;

        return $this;
    }

    public function getTeamHome(): ?Team
    {
        return $this->team_home;
    }

    public function setTeamHome(?Team $team_home): self
    {
        $this->team_home = $team_home;

        if (!$this->team_home) {
            $this->setLocation(null);
        }

        return $this;
    }

    public function getTeamExt(): ?Team
    {
        return $this->team_ext;
    }

    public function setTeamExt(?Team $team_ext): self
    {
        $this->team_ext = $team_ext;

        return $this;
    }

    public function getScore(): ?string
    {
        return $this->score;
    }

    public function setScore(?string $score): self
    {
        $this->score = $score;

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

    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    public function setLieu(?Lieu $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function __toString()
    {
        if ($this->getName()) {
            return $this->getName();
        } else return '';
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getSH1(): ?User
    {
        return $this->SH1;
    }

    public function setSH1(?User $SH1): self
    {
        $this->SH1 = $SH1;

        return $this;
    }

    public function getSH2(): ?User
    {
        return $this->SH2;
    }

    public function setSH2(?User $SH2): self
    {
        $this->SH2 = $SH2;

        return $this;
    }

    public function getSH3(): ?User
    {
        return $this->SH3;
    }

    public function setSH3(?User $SH3): self
    {
        $this->SH3 = $SH3;

        return $this;
    }

    public function getSD(): ?User
    {
        return $this->SD;
    }

    public function setSD(?User $SD): self
    {
        $this->SD = $SD;

        return $this;
    }

    public function getDDJoueuse1(): ?User
    {
        return $this->DDJoueuse1;
    }

    public function setDDJoueuse1(?User $DDJoueuse1): self
    {
        $this->DDJoueuse1 = $DDJoueuse1;

        return $this;
    }

    public function getDDJoueuse2(): ?User
    {
        return $this->DDJoueuse2;
    }

    public function setDDJoueuse2(?User $DDJoueuse2): self
    {
        $this->DDJoueuse2 = $DDJoueuse2;

        return $this;
    }

    public function getDH1Joueur1(): ?User
    {
        return $this->DH1Joueur1;
    }

    public function setDH1Joueur1(?User $DH1Joueur1): self
    {
        $this->DH1Joueur1 = $DH1Joueur1;

        return $this;
    }

    public function getDH1Joueur2(): ?User
    {
        return $this->DH1Joueur2;
    }

    public function setDH1Joueur2(?User $DH1Joueur2): self
    {
        $this->DH1Joueur2 = $DH1Joueur2;

        return $this;
    }

    public function getDH2Joueur1(): ?User
    {
        return $this->DH2Joueur1;
    }

    public function setDH2Joueur1(?User $DH2Joueur1): self
    {
        $this->DH2Joueur1 = $DH2Joueur1;

        return $this;
    }

    public function getDH2Joueur2(): ?User
    {
        return $this->DH2Joueur2;
    }

    public function setDH2Joueur2(?User $DH2Joueur2): self
    {
        $this->DH2Joueur2 = $DH2Joueur2;

        return $this;
    }

    public function getSH4(): ?User
    {
        return $this->SH4;
    }

    public function setSH4(?User $SH4): self
    {
        $this->SH4 = $SH4;

        return $this;
    }

    public function getDMXJoueur(): ?User
    {
        return $this->DMXJoueur;
    }

    public function setDMXJoueur(?User $DMXJoueur): self
    {
        $this->DMXJoueur = $DMXJoueur;

        return $this;
    }

    public function getDMXJoueuse(): ?User
    {
        return $this->DMXJoueuse;
    }

    public function setDMXJoueuse(?User $DMXJoueuse): self
    {
        $this->DMXJoueuse = $DMXJoueuse;

        return $this;
    }


    /**
     * Get the value of dejajoue
     *
     * @return  boolean
     */ 
    public function getDejajoue()
    {
        if ($this->getDateRencontre() < new \DateTime('now'))
            return true;
        else return false;
    }

    /**
     * Get interclub type Mixte / Masculin
     *
     * @return  boolean
     */ 
    public function getisMixte()
    {
        return $this->getTeam()->getMixte();
    }

    /**
     * Get BACV (Villepreux) Team
     *
     * @return  String
     */ 
    public function getTeam()
    {
        if ($this->getTeamExt() && $this->getTeamHome()) {
            if ($this->getTeamExt()->getClub()->getSlug() == 'BACV') {
                $team = $this->getTeamExt();
            } elseif ($this->getTeamHome()->getClub()->getSlug() == 'BACV') {
                $team = $this->getTeamHome();
            } else $team = null;
        }
        return $team;
    }
}