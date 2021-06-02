<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PurchaseRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={"groups"="purchase:collection"},
 *     denormalizationContext={"groups"="purchase:write"},
 *     collectionOperations={
 *     "get"={"security"="is_granted('ROLE_ADMIN') or object.getBid().getUser()==user"},
 *     },
 *     itemOperations={
 *     "get"={
 *           "normalization_context"={"groups"={"purchase:item","purchase:collection"}},
 *           "security"="is_granted('ROLE_ADMIN') or object.getBid().getUser()==user"
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
     * @Assert\DateTime()
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"purchase:collection","purchase:item"})
     * @Assert\DateTime()
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=15)
     * @Groups({"purchase:collection","purchase:item","purchase:write"})
     * @Assert\Length(min=5,max=15)
     * @Assert\NotBlank()
     */
    private $state;

    /**
     * @ORM\Column(type="text",nullable=true)
     * @Groups({"purchase:item","purchase:write"})
     *
     */
    private $error;

    /**
     * @ORM\OneToOne(targetEntity=Order::class, mappedBy="purchase", cascade={"persist", "remove"})
     * @Groups({"purchase:collection","purchase:item","purchase:write"})
     */
    private $order;

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
        return $this->order;
    }

    public function setOrder(?Order $order): self
    {
        $this->order = $order;

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
