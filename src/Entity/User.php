<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"user:collection"}},
 *     denormalizationContext={"groups"={"user:write","seller:write"}},
 *     itemOperations={
 *     "put"={"security"="is_granted('ROLE_ADMIN') or object==user"},
 *     "delete"={"security"="is_granted('ROLE_ADMIN') or object==user"},
 *     "get"={
 *           "normalization_context"={"groups"={"user:item","user:collection","seller:item"}}
 *       }
 *     }
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\InheritanceType(value="SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type")
 * @DiscriminatorMap({"user" = "User", "seller" = "Seller"})
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user:item","bid:read","user:collection"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"user:item","product:read","bid:read","user:collection","user:write"})
     */
    private $username;
    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     * @Groups({"user:item","user:write"})
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=30)
     * @Groups({"user:item","user:write"})
     */
    private $lastName;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"user:item","user:write"})
     */
    private $dateBirth;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"user:item","user:collection","user:write"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Groups({"user:item","user:collection","user:write"})
     */
    private $phone;
    /**
     * @ORM\Column(type="json")
     * @Groups({"user:item","user:write"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"user:write"})
     */
    private $password;
    /**
     * @ORM\Column(type="boolean")
     * @Groups({"user:item","user:collection","user:write"})
     */
    private $enabled;

    /**
     * @ORM\OneToMany(targetEntity=Bid::class, mappedBy="user", orphanRemoval=true)
     * @Groups({"user:item"})
     */
    private $bids;

    /**
     * @ORM\OneToMany(targetEntity=RateSeller::class, mappedBy="user", orphanRemoval=true)
     * @Groups({"user:item"})
     */
    private $rateSellers;

    /**
     * @ORM\OneToOne(targetEntity=Favorite::class, mappedBy="user", cascade={"persist", "remove"})
     * @Groups({"user:item"})
     */
    private $favorite;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="user", orphanRemoval=true)
     * @Groups({"user:item"})
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=Dispute::class, mappedBy="user", orphanRemoval=true)
     * @Groups({"user:item"})
     */
    private $disputes;

    public function __construct()
    {
        $this->bids = new ArrayCollection();
        $this->rateSellers = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->disputes = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }
    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getDateBirth()
    {
        return $this->dateBirth;
    }

    /**
     * @param mixed $dateBirth
     */
    public function setDateBirth($dateBirth): void
    {
        $this->dateBirth = $dateBirth;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }


    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->username;
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
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return Collection|Bid[]
     */
    public function getBids(): Collection
    {
        return $this->bids;
    }

    public function addBid(Bid $bid): self
    {
        if (!$this->bids->contains($bid)) {
            $this->bids[] = $bid;
            $bid->setUser($this);
        }

        return $this;
    }

    public function removeBid(Bid $bid): self
    {
        if ($this->bids->removeElement($bid)) {
            // set the owning side to null (unless already changed)
            if ($bid->getUser() === $this) {
                $bid->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RateSeller[]
     */
    public function getRateSellers(): Collection
    {
        return $this->rateSellers;
    }

    public function addRateSeller(RateSeller $rateSeller): self
    {
        if (!$this->rateSellers->contains($rateSeller)) {
            $this->rateSellers[] = $rateSeller;
            $rateSeller->setUser($this);
        }

        return $this;
    }

    public function removeRateSeller(RateSeller $rateSeller): self
    {
        if ($this->rateSellers->removeElement($rateSeller)) {
            // set the owning side to null (unless already changed)
            if ($rateSeller->getUser() === $this) {
                $rateSeller->setUser(null);
            }
        }

        return $this;
    }

    public function getFavorite(): ?Favorite
    {
        return $this->favorite;
    }

    public function setFavorite(Favorite $favorite): self
    {
        // set the owning side of the relation if necessary
        if ($favorite->getUser() !== $this) {
            $favorite->setUser($this);
        }

        $this->favorite = $favorite;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Dispute[]
     */
    public function getDisputes(): Collection
    {
        return $this->disputes;
    }

    public function addDispute(Dispute $dispute): self
    {
        if (!$this->disputes->contains($dispute)) {
            $this->disputes[] = $dispute;
            $dispute->setUser($this);
        }

        return $this;
    }

    public function removeDispute(Dispute $dispute): self
    {
        if ($this->disputes->removeElement($dispute)) {
            // set the owning side to null (unless already changed)
            if ($dispute->getUser() === $this) {
                $dispute->setUser(null);
            }
        }

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
