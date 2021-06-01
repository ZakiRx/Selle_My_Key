<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;

/**
 * @ApiResource(
 *     normalizationContext={},
 *     denormalizationContext={},
 *     collectionOperations={
 *     "get"={"security"="is_granted('ROLE_ADMIN') or object.getSeller()==user"},
 *     "post"={"security"="is_granted('ROLE_ADMIN')"}
 *     },
 *     itemOperations={
 *     "put"={"security"="is_granted('ROLE_ADMIN') or object.getSeller()==user"},
 *     "patch"={"security"="is_granted('ROLE_ADMIN') or object.getSeller()==user"},
 *     "delete"={"security"="is_granted('ROLE_ADMIN')"},
 *     "get"={"security"="is_granted('ROLE_ADMIN') or object.getSeller()==user"}
 *     }
 * )
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
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidV4Generator::class)
     */
    private $numOrder;

    /**
     * @ORM\ManyToOne(targetEntity=Seller::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $seller;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\Length(min=2,max=5)
     */
    private $status;

    /**
     * @ORM\OneToOne(targetEntity=Purchase::class, mappedBy="order", cascade={"persist", "remove"})
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
