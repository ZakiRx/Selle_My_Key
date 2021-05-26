<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PurchaseRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"="purchase:collection"},
 *     denormalizationContext={"groups"="purchase:write"},
 *     itemOperations={
 *     "put",
 *     "delete",
 *     "get"={
 *           "normalization_context"=
 *            {"groups"={"purchase:item","purchase:collection"}}
 *       }
 *     }
 * )
 * @ORM\Entity(repositoryClass=PurchaseRepository::class)
 */
class Purchase
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"purchase:collection","purchase:item"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"purchase:collection","purchase:item"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"purchase:collection","purchase:item"})
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=15)
     * @Groups({"purchase:collection","purchase:item","purchase:write"})
     */
    private $state;

    /**
     * @ORM\Column(type="text")
     * @Groups({"purchase:item","purchase:write"})
     */
    private $error;

    /**
     * @ORM\OneToOne(targetEntity=Order::class, inversedBy="purchase", cascade={"persist", "remove"})
     * @Groups({"purchase:collection","purchase:item","purchase:write"})
     */
    private $_order;

    /**
     * @ORM\OneToOne(targetEntity=Bid::class, inversedBy="purchase", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"purchase:collection","purchase:item","purchase:write"})
     */
    private $bid;

    /**
     * @ORM\OneToOne(targetEntity=Dispute::class, mappedBy="purchase", cascade={"persist", "remove"})
     * @Groups({"purchase:collection","purchase:item","purchase:write"})
     */
    private $dispute;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getError(): ?string
    {
        return $this->error;
    }

    public function setError(string $error): self
    {
        $this->error = $error;

        return $this;
    }

    public function getOrder(): ?Order
    {
        return $this->_order;
    }

    public function setOrder(?Order $_order): self
    {
        $this->_order = $_order;

        return $this;
    }

    public function getBid(): ?Bid
    {
        return $this->bid;
    }

    public function setBid(Bid $bid): self
    {
        $this->bid = $bid;

        return $this;
    }

    public function getDispute(): ?Dispute
    {
        return $this->dispute;
    }

    public function setDispute(Dispute $dispute): self
    {
        // set the owning side of the relation if necessary
        if ($dispute->getPurchase() !== $this) {
            $dispute->setPurchase($this);
        }

        $this->dispute = $dispute;

        return $this;
    }
}
