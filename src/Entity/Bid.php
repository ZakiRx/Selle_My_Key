<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BidRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"bid:collection","bid:read"}},
 *     denormalizationContext={"groups"="bid:write"},
 *     itemOperations={
        "put",
 *      "delete",
 *      "patch",
 *      "get"={
 *          "normalization_context"={"groups"={"bid:item","bid:collection","bid:read"}}
 *        }
 *      }
 *     )
 * @ORM\Entity(repositoryClass=BidRepository::class)
 */
class Bid
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("read:collection")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Groups({"bid:collection","product:read","bid:write"})
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="bids")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"bid:collection","product:read","bid:write"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="bids")
     * @Groups({"bid:item","bid:write"})
     */
    private $product;

    /**
     * @ORM\OneToOne(targetEntity=Purchase::class, mappedBy="bid", cascade={"persist", "remove"})
     */
    private $purchase;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $_user): self
    {
        $this->user = $_user;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getPurchase(): ?Purchase
    {
        return $this->purchase;
    }

    public function setPurchase(Purchase $purchase): self
    {
        // set the owning side of the relation if necessary
        if ($purchase->getBid() !== $this) {
            $purchase->setBid($this);
        }

        $this->purchase = $purchase;

        return $this;
    }
}
