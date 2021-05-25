<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numOrder;

    /**
     * @ORM\ManyToOne(targetEntity=Seller::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $seller;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $status;

    /**
     * @ORM\OneToOne(targetEntity=Purchase::class, mappedBy="_order", cascade={"persist", "remove"})
     */
    private $purchase;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumOrder(): ?string
    {
        return $this->numOrder;
    }

    public function setNumOrder(string $numOrder): self
    {
        $this->numOrder = $numOrder;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPurchase(): ?Purchase
    {
        return $this->purchase;
    }

    public function setPurchase(?Purchase $purchase): self
    {
        // unset the owning side of the relation if necessary
        if ($purchase === null && $this->purchase !== null) {
            $this->purchase->setOrder(null);
        }

        // set the owning side of the relation if necessary
        if ($purchase !== null && $purchase->getOrder() !== $this) {
            $purchase->setOrder($this);
        }

        $this->purchase = $purchase;

        return $this;
    }
}
