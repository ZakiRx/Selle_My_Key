<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $lastName;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateBirth;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    /**
     * @ORM\OneToMany(targetEntity=Bid::class, mappedBy="_user", orphanRemoval=true)
     */
    private $bids;

    /**
     * @ORM\OneToMany(targetEntity=RateSeller::class, mappedBy="_user", orphanRemoval=true)
     */
    private $rateSellers;

    /**
     * @ORM\OneToOne(targetEntity=Favorite::class, mappedBy="_user", cascade={"persist", "remove"})
     */
    private $favorite;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="_user", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=Dispute::class, mappedBy="_user", orphanRemoval=true)
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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    public function getDateBirth(): ?\DateTimeInterface
    {
        return $this->dateBirth;
    }

    public function setDateBirth(?\DateTimeInterface $dateBirth): self
    {
        $this->dateBirth = $dateBirth;

        return $this;
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
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
}
