<?php

namespace App\Entity;

use App\Repository\PurchaseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PurchaseRepository::class)
 */
class Purchase
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $state;

    /**
     * @ORM\Column(type="text")
     */
    private $error;

    /**
     * @ORM\OneToOne(targetEntity=Order::class, inversedBy="purchase", cascade={"persist", "remove"})
     */
    private $_order;

    /**
     * @ORM\OneToOne(targetEntity=Bid::class, inversedBy="purchase", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $bid;

    /**
     * @ORM\OneToOne(targetEntity=Dispute::class, mappedBy="purchase", cascade={"persist", "remove"})
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
