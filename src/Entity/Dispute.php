<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DisputeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"="dispute:item"},
 *     denormalizationContext={"groups"="dispute:write"},
 *     itemOperations={
 *       "put",
 *       "delete",
 *       "patch",
 *       "get"={
 *       "normalization_context"={"groups"={"dispute:item"}}
 *       },
 *      }
 *     )
 * @ORM\Entity(repositoryClass=DisputeRepository::class)
 */
class Dispute
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("dispute:item")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"dispute:item","dispute:write",})
     */
    private $subject;

    /**
     * @ORM\Column(type="text")
     * @Groups({"dispute:item","dispute:write"})
     */
    private $message;

    /**
     * @ORM\OneToOne(targetEntity=Purchase::class, inversedBy="dispute", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"dispute:item","dispute:write"})
     */
    private $purchase;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"dispute:item"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"dispute:item"})
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="disputes")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"dispute:item"})
     */
    private $_user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getPurchase(): ?Purchase
    {
        return $this->purchase;
    }

    public function setPurchase(Purchase $purchase): self
    {
        $this->purchase = $purchase;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->_user;
    }

    public function setUser(?User $_user): self
    {
        $this->_user = $_user;

        return $this;
    }
}
