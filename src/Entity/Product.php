<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Controller\ProductController;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"product:collection","product:read"}},
 *     denormalizationContext={"groups"="product:write"},
 *     collectionOperations={
 *     "get",
 *     "post"={"security"="is_granted('ROLE_SELLER')"}
 *     },
 *     itemOperations={
 *     "put"={"security"="is_granted('ROLE_ADMIN') or object.getSeller() == user"},
 *     "delete"={"security"="is_granted('ROLE_ADMIN') or object.getSeller() == user"},
 *     "patch"={"security"="is_granted('ROLE_ADMIN') or object.getSeller() == user"},
 *     "get"={
 *           "normalization_context"={"groups"={"product:item","product:collection","product:read"}}
 *       },
 *
 *    })
 * @ApiFilter(BooleanFilter::class,properties={"verified","enabled"})
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"product:collection"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"product:collection","product:write"})
     * @Assert\Length(min=5,max=20,maxMessage="name must be under then {{max}} char",minMessage="name must be over then {{min}} char")
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"product:collection","product:write"})
     * @Assert\Length(min=5,max=75)*
     * @Assert\NotBlank()
     */
    private $shortDescription;

    /**
     * @ORM\Column(type="text")
     * @Groups({"product:item","product:write"})
     * @Assert\Length(min=5)
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"product:item","product:write"})
     * @Assert\Url()
     */
    private $video;

    /**
     * @ORM\Column(type="float")
     * @Groups({"product:collection","product:write"})
     * @Assert\Positive()
     * @Assert\NotBlank()
     */
    private $startPrice;

    /**
     * @ORM\Column(type="float")
     * @Groups({"product:item","product:write"})
     * @Assert\Positive()
     * @Assert\NotBlank()
     */
    private $minBidPrice;

    /**
     * @ORM\Column(type="float")
     * @Groups({"product:item","product:write"})
     * @Assert\Positive()
     * @Assert\NotBlank()
     */
    private $maxBidPrice;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"product:collection","product:item","product:write"})
     * @Assert\DateTime()
     * @Assert\NotBlank()
     */
    private $startedAt;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"product:collection","product:item","product:write"})
     * @Assert\DateTime()
     * @Assert\NotBlank()
     */
    private $endedAt;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"product:item","product:write"})
     * @Assert\NotBlank()
     */
    private $verified;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"product:write"})
     * @Assert\NotBlank()
     */
    private $enabled;

    /**
     * @ORM\OneToMany(targetEntity=Bid::class, mappedBy="product")
     * @Groups({"product:item"})
     */
    private $bids;

    /**
     * @ORM\ManyToMany(targetEntity=Favorite::class, mappedBy="products")
     * @Groups({"product:collection","product:item"})
     */
    private $favorites;

    /**
     * @ORM\ManyToOne(targetEntity=Genre::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"product:collection","product:item","product:write"})
     */
    private $genre;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="product", orphanRemoval=true)
     * @Groups({"product:item"})
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity=Seller::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"product:collection","product:item","product:write"})
     */
    private $seller;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageName;

    /**
     * @ORM\Column(type="float")
     * @Groups({"product:collection","product:item","product:write"})
     * @Assert\Positive()
     */
    private $currentPrice;

    public function __construct()
    {
        $this->bids = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->favorites= new ArrayCollection();
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

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getStartPrice(): ?float
    {
        return $this->startPrice;
    }

    public function setStartPrice(float $startPrice): self
    {
        $this->startPrice = $startPrice;

        return $this;
    }

    public function getMinBidPrice(): ?float
    {
        return $this->minBidPrice;
    }

    public function setMinBidPrice(float $minBidPrice): self
    {
        $this->minBidPrice = $minBidPrice;

        return $this;
    }

    public function getMaxBidPrice(): ?float
    {
        return $this->maxBidPrice;
    }

    public function setMaxBidPrice(float $maxBidPrice): self
    {
        $this->maxBidPrice = $maxBidPrice;

        return $this;
    }

    public function getStartedAt(): ?\DateTimeInterface
    {
        return $this->startedAt;
    }

    public function setStartedAt(\DateTimeInterface $startedAt): self
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function getEndedAt(): ?\DateTimeInterface
    {
        return $this->endedAt;
    }

    public function setEndedAt(\DateTimeInterface $endedAt): self
    {
        $this->endedAt = $endedAt;

        return $this;
    }

    public function getVerified(): ?bool
    {
        return $this->verified;
    }

    public function setVerified(bool $verified): self
    {
        if($verified==null){
            $verified=false;
        }
        $this->verified = $verified;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        if($enabled==null){
            $enabled=false;
        }
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
            $bid->setProduct($this);
        }

        return $this;
    }

    public function removeBid(Bid $bid): self
    {
        if ($this->bids->removeElement($bid)) {
            // set the owning side to null (unless already changed)
            if ($bid->getProduct() === $this) {
                $bid->setProduct(null);
            }
        }

        return $this;
    }

    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorites(?Favorite $favorite): self
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites[] = $favorite;
        }
        return $this;

    }
    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): self
    {
        $this->genre = $genre;

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
            $comment->setProduct($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getProduct() === $this) {
                $comment->setProduct(null);
            }
        }

        return $this;
    }

    public function getSeller(): ?Seller
    {
        return $this->seller;
    }

    public function setSeller(?Seller $seller): self
    {
        $this->seller = $seller;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getCurrentPrice(): ?float
    {
        return $this->currentPrice;
    }

    public function setCurrentPrice(float $currentPrice): self
    {
        $this->currentPrice = $currentPrice;

        return $this;
    }
}
