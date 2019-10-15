<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */

    private $firstName;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fullName;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * @var string le token qui servira lors de l'oubli de mot de passe
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $resetToken;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $mobile;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthDate;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $license;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $classement_simple;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $classement_double;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $classement_mixte;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $code_postal;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $mobile_parent;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Saison", inversedBy="users")
     */
    private $saison;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Club", inversedBy="users")
     */
    private $club;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team", inversedBy="users")
     */
    private $team;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $rue;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $category;

    public function __construct()
    {
        $this->saison = new ArrayCollection();
    }

    /**
     * @return string|null
     */
    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    /**
     * @param string $resetToken
     */
    public function setResetToken(?string $resetToken): void
    {
        $this->resetToken = $resetToken;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(?string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getLicense(): ?string
    {
        return $this->license;
    }

    public function setLicense(?string $license): self
    {
        $this->license = $license;

        return $this;
    }

    public function getClassementSimple(): ?string
    {
        return $this->classement_simple;
    }

    public function setClassementSimple(string $classement_simple): self
    {
        $this->classement_simple = $classement_simple;

        return $this;
    }

    public function getClassementDouble(): ?string
    {
        return $this->classement_double;
    }

    public function setClassementDouble(?string $classement_double): self
    {
        $this->classement_double = $classement_double;

        return $this;
    }

    public function getClassementMixte(): ?string
    {
        return $this->classement_mixte;
    }

    public function setClassementMixte(?string $classement_mixte): self
    {
        $this->classement_mixte = $classement_mixte;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(?string $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getMobileParent(): ?string
    {
        return $this->mobile_parent;
    }

    public function setMobileParent(?string $mobile_parent): self
    {
        $this->mobile_parent = $mobile_parent;

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

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(?string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * @return Collection|InterclubVeteran[]
     */
    public function getInterclubVeterans(): Collection
    {
        return $this->interclubVeterans;
    }

    public function addInterclubVeteran(InterclubVeteran $interclubVeteran): self
    {
        if (!$this->interclubVeterans->contains($interclubVeteran)) {
            $this->interclubVeterans[] = $interclubVeteran;
            $interclubVeteran->addUser($this);
        }

        return $this;
    }

    public function removeInterclubVeteran(InterclubVeteran $interclubVeteran): self
    {
        if ($this->interclubVeterans->contains($interclubVeteran)) {
            $this->interclubVeterans->removeElement($interclubVeteran);
            $interclubVeteran->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Interclub[]
     */
    public function getInterclubs(): Collection
    {
        return $this->interclubs;
    }

    public function addInterclub(Interclub $interclub): self
    {
        if (!$this->interclubs->contains($interclub)) {
            $this->interclubs[] = $interclub;
            $interclub->addUser($this);
        }

        return $this;
    }

    public function removeInterclub(Interclub $interclub): self
    {
        if ($this->interclubs->contains($interclub)) {
            $this->interclubs->removeElement($interclub);
            $interclub->removeUser($this);
        }

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }

}
